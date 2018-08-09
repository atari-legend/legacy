<?php
/***************************************************************************
 * Insert languages into the language table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 168;

// Description of what the change will do.
$update_description = "Insert languages into the language table";

// Should the database change query execute if test is "test_fail" or "test_success"
$execute_condition = "test_success";

//This is the test query, the query should be made to get an either true or false result.
$test_condition = "SELECT *
FROM information_schema.columns
WHERE table_schema = '$db_databasename'
AND table_name = 'language' LIMIT 1";

// Database change
$database_update_sql = "INSERT INTO `language` VALUES ('1', 'English'), ('2', 'German'), ('3', 'French'), ('4', 'Dutch'), ('5', 'Italian'), ('6', 'Spanish'), ('7', 'Polish'), ('8', 'Russian'), ('9', 'Japanese'), ('10', 'Portuguese'), ('11', 'Swedish'), ('12', 'Chinese'), ('13', 'Catalan'), ('14', 'Ukrainian'), ('15', 'Norwegian'), ('16', 'Finnish'), ('17', 'Vietnamese'), ('18', 'Czech'), ('19', 'Hungarian'), ('20', 'Korean'), ('21', 'Indonesian'), ('22', 'Turkish'), ('23', 'Romanian'), ('24', 'Persian'), ('25', 'Arabic'), ('26', 'Danish'), ('27', 'Esperanto'), ('28', 'Serbian'), ('29', 'Lithuanian'), ('30', 'Slovak'), ('31', 'Malay'), ('32', 'Hebrew'), ('33', 'Bulgarian'), ('34', 'Slovenian'), ('36', 'Kazakh'), ('37', 'Waray-Waray'), ('38', 'Basque'), ('39', 'Croatian'), ('40', 'Hindi'), ('41', 'Estonian'), ('42', 'Azerbaijani'), ('43', 'Galician'), ('44', 'Simple English'), ('45', 'Norwegian (Nynorsk)'), ('46', 'Thai'), ('47', 'Newar / Nepal Bhasa'), ('48', 'Greek'), ('49', 'Aromanian'), ('50', 'Latin'), ('51', 'Occitan'), ('52', 'Tagalog'), ('53', 'Haitian'), ('54', 'Macedonian'), ('55', 'Georgian'), ('56', 'Serbo-Croatian'), ('57', 'Telugu'), ('58', 'Piedmontese'), ('59', 'Cebuano'), ('60', 'Tamil'), ('62', 'Breton'), ('63', 'Latvian'), ('64', 'Javanese'), ('65', 'Albanian'), ('66', 'Belarusian'), ('67', 'Marathi'), ('68', 'Welsh'), ('69', 'Luxembourgish'), ('70', 'Icelandic'), ('71', 'Bosnian'), ('72', 'Yoruba'), ('73', 'Malagasy'), ('74', 'Aragonese'), ('75', 'Bishnupriya Manipuri'), ('76', 'Lombard'), ('77', 'West Frisian'), ('78', 'Bengali'), ('79', 'Ido'), ('80', 'Swahili'), ('81', 'Gujarati'), ('82', 'Malayalam'), ('83', 'Western Panjabi'), ('84', 'Afrikaans'), ('85', 'Low Saxon'), ('86', 'Sicilian'), ('87', 'Urdu'), ('88', 'Kurdish'), ('89', 'Cantonese'), ('90', 'Armenian'), ('91', 'Quechua'), ('92', 'Sundanese'), ('93', 'Nepali'), ('94', 'Zazaki'), ('95', 'Asturian'), ('96', 'Tatar'), ('97', 'Neapolitan'), ('98', 'Irish'), ('99', 'Chuvash'), ('100', 'Samogitian'), ('101', 'Walloon'), ('102', 'Amharic'), ('103', 'Kannada'), ('104', 'Alemannic'), ('105', 'Buginese'), ('106', 'Burmese'), ('107', 'Interlingua')";

// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
