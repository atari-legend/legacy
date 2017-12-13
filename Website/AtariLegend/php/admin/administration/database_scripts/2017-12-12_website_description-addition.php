<?php
/*
 * Additional upgrade script to transfer the website_description table contents
 * into website.description, and then drop website_description
 */

$mysqli->query("ALTER TABLE website ADD description TEXT NULL")
    or die("Couldn't add description column to website: ".$mysqli->error);

$mysqli->query("UPDATE website
    JOIN website_description ON website_description.website_id = website.website_id
    SET website.description = website_description.website_description_text")
    or die("Couldn't insert website descriptions: ".$mysqli->error);

$mysqli->query("DROP TABLE website_description")
    or die("Couldn't drop the website_description table: ".$mysqli->error) ;

?>
