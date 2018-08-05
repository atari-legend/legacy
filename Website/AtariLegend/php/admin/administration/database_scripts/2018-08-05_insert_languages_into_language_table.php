<?php
/***************************************************************************
 * Insert languages into the language table
 **************************************************************************/

// Unique identifier set by developer.
$database_update_id = 167;

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
$database_update_sql = "INSERT INTO `language` VALUES ('1', 'English', 'en'), ('2', 'German', 'de'), ('3', 'French', 'fr'), ('4', 'Dutch', 'nl'), ('5', 'Italian', 'it'), ('6', 'Spanish', 'es'), ('7', 'Polish', 'pl'), ('8', 'Russian', 'ru'), ('9', 'Japanese', 'ja'), ('10', 'Portuguese', 'pt'), ('11', 'Swedish', 'sv'), ('12', 'Chinese', 'zh'), ('13', 'Catalan', 'ca'), ('14', 'Ukrainian', 'uk'), ('15', 'Norwegian', 'no'), ('16', 'Finnish', 'fi'), ('17', 'Vietnamese', 'vi'), ('18', 'Czech', 'cs'), ('19', 'Hungarian', 'hu'), ('20', 'Korean', 'ko'), ('21', 'Indonesian', 'id'), ('22', 'Turkish', 'tr'), ('23', 'Romanian', 'ro'), ('24', 'Persian', 'fa'), ('25', 'Arabic', 'ar'), ('26', 'Danish', 'da'), ('27', 'Esperanto', 'eo'), ('28', 'Serbian', 'sr'), ('29', 'Lithuanian', 'lt'), ('30', 'Slovak', 'sk'), ('31', 'Malay', 'ms'), ('32', 'Hebrew', 'he'), ('33', 'Bulgarian', 'bg'), ('34', 'Slovenian', 'sl'), ('36', 'Kazakh', 'kk'), ('37', 'Waray-Waray', 'war'), ('38', 'Basque', 'eu'), ('39', 'Croatian', 'hr'), ('40', 'Hindi', 'hi'), ('41', 'Estonian', 'et'), ('42', 'Azerbaijani', 'az'), ('43', 'Galician', 'gl'), ('44', 'Simple English', 'simple'), ('45', 'Norwegian (Nynorsk)', 'nn'), ('46', 'Thai', 'th'), ('47', 'Newar / Nepal Bhasa', 'new'), ('48', 'Greek', 'el'), ('49', 'Aromanian', 'roa-rup'), ('50', 'Latin', 'la'), ('51', 'Occitan', 'oc'), ('52', 'Tagalog', 'tl'), ('53', 'Haitian', 'ht'), ('54', 'Macedonian', 'mk'), ('55', 'Georgian', 'ka'), ('56', 'Serbo-Croatian', 'sh'), ('57', 'Telugu', 'te'), ('58', 'Piedmontese', 'pms'), ('59', 'Cebuano', 'ceb'), ('60', 'Tamil', 'ta'), ('62', 'Breton', 'br'), ('63', 'Latvian', 'lv'), ('64', 'Javanese', 'jv'), ('65', 'Albanian', 'sq'), ('66', 'Belarusian', 'be'), ('67', 'Marathi', 'mr'), ('68', 'Welsh', 'cy'), ('69', 'Luxembourgish', 'lb'), ('70', 'Icelandic', 'is'), ('71', 'Bosnian', 'bs'), ('72', 'Yoruba', 'yo'), ('73', 'Malagasy', 'mg'), ('74', 'Aragonese', 'an'), ('75', 'Bishnupriya Manipuri', 'bpy'), ('76', 'Lombard', 'lmo'), ('77', 'West Frisian', 'fy'), ('78', 'Bengali', 'bn'), ('79', 'Ido', 'io'), ('80', 'Swahili', 'sw'), ('81', 'Gujarati', 'gu'), ('82', 'Malayalam', 'ml'), ('83', 'Western Panjabi', 'pnb'), ('84', 'Afrikaans', 'af'), ('85', 'Low Saxon', 'nds'), ('86', 'Sicilian', 'scn'), ('87', 'Urdu', 'ur'), ('88', 'Kurdish', 'ku'), ('89', 'Cantonese', 'zh-yue'), ('90', 'Armenian', 'hy'), ('91', 'Quechua', 'qu'), ('92', 'Sundanese', 'su'), ('93', 'Nepali', 'ne'), ('94', 'Zazaki', 'diq'), ('95', 'Asturian', 'ast'), ('96', 'Tatar', 'tt'), ('97', 'Neapolitan', 'nap'), ('98', 'Irish', 'ga'), ('99', 'Chuvash', 'cv'), ('100', 'Samogitian', 'bat-smg'), ('101', 'Walloon', 'wa'), ('102', 'Amharic', 'am'), ('103', 'Kannada', 'kn'), ('104', 'Alemannic', 'als'), ('105', 'Buginese', 'bug'), ('106', 'Burmese', 'my'), ('107', 'Interlingua', 'ia')"; 
 
// If the update should auto execute without user interaction set to "yes".
$database_autoexecute = "yes";

// This var should almost allways be set to "no", it is only used for certain corner cases where
// the database change has already been done in some other way and we only want to update the
// change database.
$force_insert = "no";
