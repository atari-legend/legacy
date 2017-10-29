<?php

# First, drop some primary key constraint on VARCHAR columns, because they
# can't be converted to BLOB when they have a primary key constraint. They
# will be restored at the end
foreach (array("news_search_wordlist") as $table) {
    $mysqli->query("ALTER TABLE $table DROP PRIMARY KEY")
        or die("Unable to drop primary key constraint for $table: ".$mysqli->error);
}

# Also drop some indexes for the same reason
foreach (array(
    "users" => array("userid", "userid_2", "userid_3"),
    "demo" => array("demo_name")
    ) as $table => $indices) {
    foreach ($indices as $index) {
        $mysqli->query("ALTER TABLE $table DROP INDEX $index")
            or die("Unable to drop index $index for $table: ".$mysqli->error);
    }
}

# Select all tables with non utf8 charset
$res1 = $mysqli->query("
SELECT
    SUBSTRING(tables.table_name FROM 1) as tbl_name
FROM
    information_schema.tables,
    information_schema.collation_character_set_applicability CCSA
WHERE
    CCSA.collation_name = tables.table_collation
AND tables.table_schema = '$db_databasename'
AND CCSA.character_set_name != 'utf8'") or die("Unable to retrieve the list of non-utf8 tables: ".$mysqli->error);

while ($tables = mysqli_fetch_assoc($res1)) {
    $table_name = $tables['tbl_name'];

    # Select non utf8 columns
    $res2 = $mysqli->query("
        SELECT
            column_name,
            column_type
        FROM
            information_schema.columns
        WHERE
            table_schema = '$db_databasename'
        AND
            table_name = '$table_name'
        AND
            character_set_name != 'utf8'");

    while ($columns = mysqli_fetch_assoc($res2)) {
        $column_name = $columns['column_name'];
        $column_type = $columns['column_type'];

        # Convert column to BLOB, and then back to utf8, as per the MySQL
        # manual to convert tables that erroneously stored utf8 data in non-utf8 columns
        # See: https://dev.mysql.com/doc/refman/5.7/en/alter-table.html#alter-table-character-set
        $mysqli->query("ALTER TABLE `$table_name` CHANGE `$column_name` `$column_name` BLOB")
            or die("Unable to convert $table_name.$column_name to BLOB: ".$mysqli->error);
        $mysqli->query("ALTER TABLE `$table_name` CHANGE `$column_name` `$column_name` $column_type CHARACTER SET utf8")
            or die("Unable to convert $table_name.$column_name back to $column_type: ".$mysqli->error);
    }

    # Change default table charset, so that any future columns created
    # will be utf8
    $mysqli->query("ALTER TABLE `$table_name` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")
        or die("Unable to change default character set of $table_name: ".$mysqli->error);
}

# Before restoring indexes we need to cleanup the news search table
# Because we're changing the collation to a case insensitive one, some rows
# will be considered duplicate, like 'k' and 'K'. We need to pick one, and re-link
# everything to it.

# Find every duplicate news_word_text, i.e. rows like:
# 123  | k
# ...  | ...
# 456  | k
$result = $mysqli->query("
SELECT
    news_word_text,
    COUNT(news_word_id) c
FROM
    news_search_wordlist
    group by news_word_text
HAVING
    c > 1") or die("Unable to query news_word_text: ".$mysqli->error);

while ($row = mysqli_fetch_assoc($result)) {
    $word = $row["news_word_text"];

    # For our word (e.g. 'k'), find all the IDs, e.g.
    # 123  | k
    # ...  | ...
    # 456  | k
    $result_words = $mysqli->query("SELECT news_word_id FROM news_search_wordlist WHERE news_word_text = '$word'")
        or die("Couldn't select '$word' from news_search_wordlist");

    # There must be at least 2 IDs since we're looking at duplicate words
    # Pick the first one as the one we will be relinking to
    $row_keep = mysqli_fetch_assoc($result_words);
    $word_id_to_keep = $row_keep["news_word_id"];

    # Then loop over all the other ones, and relink data to the one to keep
    while ($row_relink = mysqli_fetch_assoc($result_words)) {
        $word_id_to_relink = $row_relink["news_word_id"];

        # Relink data to the word we keep
        $mysqli->query("UPDATE news_search_wordmatch SET news_word_id = $word_id_to_keep WHERE news_word_id = $word_id_to_relink")
            or die("Unable to relink word id $word_id_to_relink to $word_id_to_keep: ".$mysqli->error);

        # Delete duplicate word
        $mysqli->query("DELETE FROM news_search_wordlist WHERE news_word_id = $word_id_to_relink")
            or die("Unable to delete duplicated word: ".$mysqli->error);
    }
}

# Restore primary key constraints that we dropped previously
foreach (array(
    "news_search_wordlist" => "news_word_text",
    ) as $table => $column) {
    $mysqli->query("ALTER TABLE $table ADD PRIMARY KEY ($column)")
        or die("Unable to restore primary key constraint for $table.$column: ".$mysqli->error);
}

# Restore indexes we dropped previously
foreach ( array (
    "users" => array(
        "userid" => "userid",
        "userid_2" => "userid",
        "userid_3" => "userid"),
    "demo" => array (
        "demo_name" => "demo_name")
    ) as $table => $indices) {
    foreach ($indices as $index_name => $column) {
        $mysqli->query("ALTER TABLE $table ADD INDEX $index_name ($column)")
            or die("Unable to restore index $index_name on $table.$column: ".$mysqli->error);
    }
}

# Finally, change the database default charset so that any future table
# created will be utf8 by default
$mysqli->query("ALTER DATABASE `$db_databasename` CHARACTER SET utf8 COLLATE utf8_general_ci")
    or die("Unable to alter database character set: ".$mysqli->error);

?>
