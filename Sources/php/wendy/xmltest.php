<?php

/*
Section is games, demos, menus, tools, news, interview, article, links




*/

$string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<change>
  <user>
    <user_id>3</user_id>
    <user_name>ST Graveyard</user_name>
  </user>
  <section>
    <games>
      <game_id>1</game_id>
      <game_name>Gods</game_name>
    </games>
  </section>
  <change_type>modified</change_type>
</change>
XML;


$xml = simplexml_load_string($string);
echo "<pre>";
print_r($xml);
echo "</pre>";
?>
