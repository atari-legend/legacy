<?php
/*
 * Manage individual relationships to games (authors)
 */

require_once __DIR__.'/../../config/common.php';
require_once __DIR__.'/../../config/admin.php';

require_once __DIR__."/../../common/DAO/GameDAO.php";
require_once __DIR__."/../../common/DAO/IndividualDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";

$gameDao = new \AL\Common\DAO\GameDAO($mysqli);
$individualDao = new \AL\Common\DAO\IndividualDAO($mysqli);
$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);

$game = $gameDao->getGame($game_id);
$individual = $individualDao->getIndividual($individual_id);

switch ($action) {
    case "remove":
        $gameDao->removeAuthor($game_id, $individual_id, $author_type_id);

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Creator",
                $individual_id,
                $individual->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_DELETE
            )
        );

        $_SESSION['edit_message'] = "Removed ".$individual->getName()." from ".$game->getName();
        break;

    case "add":
        $gameDao->addAuthor($game_id, $individual_id, $author_type_id);

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Creator",
                $individual_id,
                $individual->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_INSERT
            )
        );

        $_SESSION['edit_message'] = "Added ".$individual->getName()." to ".$game->getName();
        break;

    case "update":
        $gameDao->updateAuthorType($game_id, $individual_id, $author_type_id, $new_author_type_id);

        $changeLogDao->insertChangeLog(
            new \AL\Common\Model\Database\ChangeLog(
                -1,
                "Games",
                $game_id,
                $game->getName(),
                "Creator",
                $individual_id,
                $individual->getName(),
                $_SESSION["user_id"],
                \AL\Common\Model\Database\ChangeLog::ACTION_UPDATE
            )
        );

        $_SESSION['edit_message'] = "Updated ".$individual->getName()." role on ".$game->getName();
        break;
}

header("Location: games_detail.php?game_id=$game_id#gd_authors");
?>
