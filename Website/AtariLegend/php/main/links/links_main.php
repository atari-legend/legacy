<?php
require_once __DIR__."/../../config/common.php";
require_once __DIR__."/../../common/DAO/LinkDAO.php";
require_once __DIR__."/../../common/DAO/LinkCategoryDAO.php";

require_once __DIR__."/../../common/tiles/screenstar.php";
require_once __DIR__."/../../common/tiles/did_you_know_tile.php";
require_once __DIR__."/../../common/Model/Breadcrumb.php";

$linkCategoryDao = new AL\Common\DAO\LinkCategoryDAO($mysqli);
$linkDao = new AL\Common\DAO\LinkDAO($mysqli);

$smarty->assign('categories', $linkCategoryDao->getAllCategories());
$smarty-> assign('offset', isset($offset) ? $offset : 0);
$smarty->assign('total_count', $linkDao->getLinkCount());

$breadcrumb = array(
    new AL\Common\Model\Breadcrumb("/links/links_main.php", "Links")
);

if (isset($category_id)) {
    $category = $linkCategoryDao->getCategory($category_id);
    $smarty->assign('current_category', $category);
    $smarty->assign('links', $linkDao->getAllLinksForCategory($category_id, isset($offset) ? $offset : null));
    $smarty->assign('count', $linkDao->getLinkCount($category_id));
    $breadcrumb[] = new AL\Common\Model\Breadcrumb(
        "/links/links_main.php?category_id=$category_id",
        $category->getName()
    );
} else {
    $smarty->assign('links', $linkDao->getAllLinks(isset($offset) ? $offset : null));
    $smarty->assign('count', $linkDao->getLinkCount());
}

$smarty->assign('breadcrumb', $breadcrumb);

$smarty->display("file:${mainsite_template_folder}links_main.html");
