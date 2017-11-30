<?php
/**
 * Generate a sitemap index files
 *
 * This generates a sitemap index file, splitting the games into sub-sitemaps
 * (1 per letter of the alphabet)
 */

require("../../config/common.php");

header("Content-Type: application/xml");

$smarty->assign("range", array_merge(range(0, 9), range("a", "z")));
$smarty->display("file:${mainsite_template_folder}sitemap_index.xml");
