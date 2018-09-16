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
require_once __DIR__."/../../common/DAO/DeveloperRoleDAO.php";

$changeLogDao = new \AL\Common\DAO\ChangeLogDAO($mysqli);
$engineDao = new \AL\Common\DAO\EngineDAO($mysqli);
$programmingLanguageDao = new \AL\Common\DAO\ProgrammingLanguageDAO($mysqli);
$gameGenreDao = new \AL\Common\DAO\GameGenreDAO($mysqli);
$portDao = new \AL\Common\DAO\PortDAO($mysqli);
$individualRoleDao = new \Al\Common\DAO\IndividualRoleDAO($mysqli);
$developerRoleDao = new \Al\Common\DAO\DeveloperRoleDAO($mysqli);

switch ($_POST['action']) {
	case "Add engine":
        $engineDao->addGameEngine($engine_new);
        
        $new_engine_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_engine_id, 'Games Engine', $new_engine_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$engine_new has been added" ;
        break;
        
    case "Delete engine":
        create_log_entry('Games Config', $engine_id_edit, 'Games Engine', $engine_id_edit, 'Delete', $_SESSION['user_id']);
        
        $engineDao->deleteGameEngine($engine_id_edit);       

        $_SESSION['edit_message'] = "Engine has been deleted" ;
        break;
        
    case "Modify engine":
        $engineDao->updateGameEngine($engine_id_edit, $engine_edit);

        create_log_entry('Games Config', $engine_id_edit, 'Games Engine', $engine_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Engine has been updated" ;
        break;
        
    case "Add language":
        $programmingLanguageDao->addProgrammingLanguage($programming_language_new);
        
        $new_programming_language_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_programming_language_id, 'Programming Language',$new_programming_language_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$programming_language_new has been added" ;
        break;
        
    case "Delete language":
        create_log_entry('Games Config', $programming_language_id_edit, 'Programming Language', $programming_language_id_edit, 'Delete', $_SESSION['user_id']);
        
        $programmingLanguageDao->deleteProgrammingLanguage($programming_language_id_edit);       

        $_SESSION['edit_message'] = "Programming language has been deleted" ;
        break;
        
    case "Modify language":
        $programmingLanguageDao->updateProgrammingLanguage($programming_language_id_edit, $programming_language_edit); 

        create_log_entry('Games Config', $programming_language_id_edit, 'Programming Language', $programming_language_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Programming language has been updated" ;
        break;
    
    case "Add genre":
        $gameGenreDao->addGenre($genre_new);
        
        $new_genre_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_genre_id, 'Genre',$new_genre_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$genre_new has been added" ;
        break;
        
    case "Delete genre":
        create_log_entry('Games Config', $genre_id_edit, 'Genre', $genre_id_edit, 'Delete', $_SESSION['user_id']);
        
        $gameGenreDao->deleteGenre($genre_id_edit);       

        $_SESSION['edit_message'] = "Genre has been deleted" ;
        break;
        
    case "Modify genre":
        $gameGenreDao->updateGenre($genre_id_edit, $genre_edit);

        create_log_entry('Games Config', $genre_id_edit, 'Genre', $genre_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Genre has been updated" ;
        break;
        
    case "Add port":
        $portDao->addPort($port_new);
        
        $new_port_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_port_id, 'Port',$new_port_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$port_new has been added" ;
        break;
        
    case "Delete port":
        create_log_entry('Games Config', $port_id_edit, 'Port', $port_id_edit, 'Delete', $_SESSION['user_id']);
        
        $portDao->deletePort($port_id_edit);       

        $_SESSION['edit_message'] = "Port has been deleted" ;
        break;
        
    case "Modify port":        
        $portDao->updatePort($port_id_edit, $port_edit);      

        create_log_entry('Games Config', $port_id_edit, 'Port', $port_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Port has been updated" ;
        break;
        
    case "Add ind role":
        $individualRoleDao->addIndividualRole($individual_role_new);
        
        $new_individual_role_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_individual_role_id, 'Individual Role',$new_individual_role_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$individual_role_new has been added" ;
        break;
        
    case "Delete ind role":
        create_log_entry('Games Config', $individual_role_id_edit, 'Individual Role', $individual_role_id_edit, 'Delete', $_SESSION['user_id']);
        
        $individualRoleDao->deleteIndividualRole($individual_role_id_edit);       

        $_SESSION['edit_message'] = "Individual role has been deleted" ;
        break;
        
    case "Modify ind role":       
        $individualRoleDao->updateIndividualRole($individual_role_id_edit, $individual_role_edit);       
        
        create_log_entry('Games Config', $individual_role_id_edit, 'Individual Role', $individual_role_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Individual role has been updated" ;
        break;
        
    case "Add dev role":
        $developerRoleDao->addDeveloperRole($developer_role_new);
        
        $new_developer_role_id = $mysqli->insert_id;
        
        create_log_entry('Games Config', $new_developer_role_id, 'Developer Role',$new_developer_role_id, 'Insert', $_SESSION['user_id']);
        
        $_SESSION['edit_message'] = "$developer_role_new has been added" ;
        break;
        
    case "Delete dev role":
        create_log_entry('Games Config', $developer_role_id_edit, 'Developer Role', $developer_role_id_edit, 'Delete', $_SESSION['user_id']);
        
        $developerRoleDao->deleteDeveloperRole($developer_role_id_edit);       

        $_SESSION['edit_message'] = "Developer role has been deleted" ;
        break;
        
    case "Modify dev role":       
        $developerRoleDao->updateDeveloperRole($developer_role_id_edit, $developer_role_edit);       
        
        create_log_entry('Games Config', $developer_role_id_edit, 'Developer Role', $developer_role_id_edit, 'Update', $_SESSION['user_id']);

        $_SESSION['edit_message'] = "Developer role has been updated" ;
        break;
}

header("Location: games_config.php");
