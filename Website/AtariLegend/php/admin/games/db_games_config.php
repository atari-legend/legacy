<?php
/*
 * Manage all the game config features
 */
 
require_once __DIR__.'/../../config/common.php';
require_once __DIR__.'/../../config/admin.php';
require_once __DIR__.'/../../config/admin_rights.php';

require_once __DIR__."/../../common/DAO/EngineDAO.php";
require_once __DIR__."/../../common/DAO/ChangeLogDAO.php";
require_once __DIR__."/../../common/DAO/ProgrammingLanguageDAO.php";
require_once __DIR__."/../../common/DAO/GameGenreDAO.php";
require_once __DIR__."/../../common/DAO/PortDAO.php";
require_once __DIR__."/../../common/DAO/IndividualRoleDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$engineDao = new \AL\Common\DAO\EngineDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$portDao = new \AL\Common\DAO\PortDAO($mysqli);
$individualRoleDao = new \Al\Common\DAO\IndividualRoleDAO($mysqli);

switch ($action) {
	case "add_engine":
        $engineDao->addGameEngine($engine_new);
        
        $new_engine_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_engine_id, 'Games Engine', $new_engine_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$engine_new has been added" ;
        break;
        
    case "delete_engine":
        create_log_entry('Games Config', $engine_id, 'Games Engine', $engine_id, 'Delete', $_SESSION['user_id']);
        
        $engineDao->deleteGameEngine($engine_id);       

        $_SESSION['edit_message'] = "Engine has been deleted" ;
        break;
        
    case "modify_engine":
        $engineDao->updateGameEngine($engine_id, $engine_name);

        create_log_entry('Games Config', $engine_id, 'Games Engine', $engine_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Engine has been updated" ;
        break;
        
    case "add_programming_language":
        $programmingLanguageDao->addProgrammingLanguage($programming_language_new);
        
        $new_programming_language_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_programming_language_id, 'Programming Language',$new_programming_language_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$programming_language_new has been added" ;
        break;
        
    case "delete_programming_language":
        create_log_entry('Games Config', $programming_language_id, 'Programming Language', $programming_language_id, 'Delete', $_SESSION['user_id']);
        
        $programmingLanguageDao->deleteProgrammingLanguage($programming_language_id);       

        $_SESSION['edit_message'] = "Programming language has been deleted" ;
        break;
        
    case "modify_programming_language":
        $programmingLanguageDao->updateProgrammingLanguage($programming_language_id, $programming_language_name); 

        create_log_entry('Games Config', $programming_language_id, 'Programming Language', $programming_language_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Programming language has been updated" ;
        break;
    
    case "add_genre":
        $gameGenreDao->addGenre($genre_new);
        
        $new_genre_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_genre_id, 'Genre',$new_genre_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$genre_new has been added" ;
        break;
        
    case "delete_genre":
        create_log_entry('Games Config', $genre_id, 'Genre', $genre_id, 'Delete', $_SESSION['user_id']);
        
        $gameGenreDao->deleteGenre($genre_id);       

        $_SESSION['edit_message'] = "Genre has been deleted" ;
        break;
        
    case "modify_genre":
        $gameGenreDao->updateGenre($genre_id, $genre_name);

        create_log_entry('Games Config', $genre_id, 'Genre', $genre_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Genre has been updated" ;
        break;
        
    case "add_port":
        $portDao->addPort($port_new);
        
        $new_port_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_port_id, 'Port',$new_port_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$port_new has been added" ;
        break;
        
    case "delete_port":
        create_log_entry('Games Config', $port_id, 'Port', $port_id, 'Delete', $_SESSION['user_id']);
        
        $portDao->deletePort($port_id);       

        $_SESSION['edit_message'] = "Port has been deleted" ;
        break;
        
    case "modify_port":        
        $portDao->updatePort($port_id, $port_name);      

        create_log_entry('Games Config', $port_id, 'Port', $port_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Port has been updated" ;
        break;
        
    case "add_individual_role":
        $individualRoleDao->addIndividualRole($individual_role_new);
        
        $new_individual_role_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_individual_role_id, 'Individual Role',$new_individual_role_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$individual_role_new has been added" ;
        break;
        
    case "delete_individual_role":
        create_log_entry('Games Config', $individual_role_id, 'Individual Role', $individual_role_id, 'Delete', $_SESSION['user_id']);
        
        $individualRoleDao->deleteIndividualRole($individual_role_id);       

        $_SESSION['edit_message'] = "Individual role has been deleted" ;
        break;
        
    case "modify_individual_role":       
        $individualRoleDao->updateIndividualRole($individual_role_id, $individual_role_name);       
        
        create_log_entry('Games Config', $individual_role_id, 'Individual role', $individual_role_id, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Individual role has been updated" ;
        break;
}

header("Location: games_config.php");
