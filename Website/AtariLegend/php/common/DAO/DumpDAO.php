<?php
namespace AL\Common\DAO;

require_once __DIR__."/../../lib/Db.php" ;
require_once __DIR__."/../Model/Dump/Dump.php" ;
require_once __DIR__."/../../vendor/pclzip/pclzip/pclzip.lib.php" ;

/**
 * DAO for Dump
 */
class DumpDAO {
    private $mysqli;

    const FORMAT_STX = 'STX';
    const FORMAT_MSA = 'MSA';
    const FORMAT_RAW = 'RAW';
    const FORMAT_SCP = 'SCP';

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get all the formats
     * @return String[] A list of formats
     */
    public function getFormats() {
        return array(
            DumpDAO::FORMAT_STX,
            DumpDAO::FORMAT_MSA,
            DumpDAO::FORMAT_RAW,
            DumpDAO::FORMAT_SCP
        );
    }

     /**
     * Add a dump to a media
     *
     * @param int media_id
     * @param varchar format
     * @param varchar file name
     * @param text info
     */
    public function addDumpToMedia(
        $media_id,
        $format,
        $file_name,
        $tempfilename,
        $info,
        $game_file_temp_path,
        $game_file_path,
        $filesize
    ) {
        //check the extension of the file, is it zipped or not?
        $file_ext = strrchr($file_name, ".");
        $file_ext = explode(".", $file_ext);
        $file_ext = strtolower($file_ext[1]);
        
        // If it is ZIP, do all the zippidy zip stuff
        if ($file_ext == 'zip') {
            // Time for zip magic
            $zip = new \PclZip("$tempfilename");

            // Obtain the contentlist of the zip file.
            if (($list = $zip->listContent()) == 0) {
                die("Error : " . $zip->errorInfo(true));
            }

            // Get the filename from the returned array
            $filename = $list[0]['filename'];

            // Split the filename to get the extention
            $ext = strrchr($filename, ".");

            // Get rid of the . in the extention
            $ext = explode(".", $ext);

            // convert to lowercase just incase....
            $ext = strtolower($ext[1]);

            // check if the extention is valid.
            if ($ext == "stx" || $ext == "msa" || $ext == "st"  || $file_ext == "scp") { // pretty isn't it? ;)
            } else {
                exit("Try uploading a diskimage type that is allowed, like stx or msa not $ext");
            }
        } else {
            if ($file_ext == "stx" || $file_ext == "msa" ||
                $file_ext == "st" || $file_ext == "scp") { // pretty isn't it? ;)
            } else {
                exit("Try uploading a diskimage type that is allowed $file_ext");
            }
        }
        
        // create a timestamp for the date of upload
        $timestamp = time();

        $stmt = \AL\Db\execute_query(
            "DumpDAO: addDumptoMedia",
            $this->mysqli,
            "INSERT INTO dump (`media_id`, `format`, `info`, `date`, `size`, user_id ) VALUES (?, ?, ?, ?, ?, ?)",
            "issiii", $media_id, $format, $info, $timestamp, $filesize, $_SESSION['user_id']
        );

        //get the new dump id
        $new_dump_id = $this->mysqli->insert_id;
        
        if ($file_ext == 'zip') {
            // Time to unzip the file to the temporary directory
            $archive = new \PclZip("$tempfilename");

            if ($archive->extract(PCLZIP_OPT_PATH, "$game_file_temp_path") == 0) {
                die("Error : " . $archive->errorInfo(true));
            }

            // rename diskimage to increment number
            rename("$game_file_temp_path$filename", "$game_file_temp_path$new_dump_id.$ext")
                or die("couldn't rename the file");
        } else {
            $file_data = rename("$tempfilename", "$game_file_temp_path$new_dump_id.$file_ext");
        }

        //Time to rezip file and place it in the proper location.
        $archive = new \PclZip("$game_file_path$new_dump_id.zip");
        if ($file_ext == 'zip') {
            $v_list  = $archive->create("$game_file_temp_path$new_dump_id.$ext", PCLZIP_OPT_REMOVE_ALL_PATH);
        } else {
            $v_list  = $archive->create("$game_file_temp_path$new_dump_id.$file_ext", PCLZIP_OPT_REMOVE_ALL_PATH);
        }
        if ($v_list == 0) {
            die("Error : " . $archive->errorInfo(true));
        }

        // Time to do the safeties, here we do a sha512 file hash that we later enter into
        // the database, this will be used in the download function to check everytime the file
        // is being downloaded... if the hashes don't match, then datacorruption have changed the file.
        $crc = openssl_digest("$game_file_path$new_dump_id.zip", 'sha512');

        $stmt = \AL\Db\execute_query(
            "DumpDAO: addDumptoMedia",
            $this->mysqli,
            "UPDATE dump SET sha512 = ? WHERE id = ?",
            "si", $crc, $new_dump_id
        );

        // Chmod file so that we can backup/delete files through ftp.
        chmod("$game_file_path$new_dump_id.zip", 0777);

        // Delete the unzipped file in the temporary directory
        unlink("$game_file_temp_path$new_dump_id.$ext");

        $stmt->close();
    }

    /**
     * Get all dumps from media
     *
     * @return \AL\Common\Model\Dump\Dump[] An array of dumps
     */
    public function getAllDumpsFromMedia($media_id) {
        $stmt = \AL\Db\execute_query(
            "DumpDAO: getAllDumpsFromMedia",
            $this->mysqli,
            "SELECT id, format, sha512, date, size, info, dump.user_id, users.userid FROM dump
            LEFT JOIN users ON (users.user_id = dump.user_id)
            WHERE media_id = ?",
            "i", $media_id
        );

        \AL\Db\bind_result(
            "DumpDAO: getAllDumpsFromMedia",
            $stmt,
            $id, $format, $sha512, $date, $size, $info, $user_id, $userid
        );

        $dump = [];
        while ($stmt->fetch()) {
            $dump[] = new \AL\Common\Model\Dump\Dump(
                $id, $media_id, $format, $sha512, $date, $size, $info,
                new \AL\Common\Model\User\User($user_id, $userid, null, null, null, null, null)
            );
        }

        $stmt->close();

        return $dump;
    }
    
      /**
     * delete a dump from a media
     *
     * @param int dump_id
     */
    public function deleteDumpFromMedia($dump_id, $game_file_path) {
        $stmt = \AL\Db\execute_query(
            "DumpDAO: deleteDumpFromMedia",
            $this->mysqli,
            "DELETE FROM dump WHERE id = ?",
            "i", $dump_id
        );
        
        unlink("$game_file_path$dump_id.zip");
        
        $stmt->close();
    }
}
