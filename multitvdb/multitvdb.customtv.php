<?php
global $content;
global $row;
if (IN_MANAGER_MODE != 'true') {
    die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}

define('MULTITVDB', trim(str_replace(dirname(dirname(__FILE__)), '', dirname(__FILE__)), '/\\'));

include_once(realpath(dirname(__FILE__)) . '/' . MULTITVDB . '.connector.php');

$iconsProgram = new multiTvDbClass($language, array(
    'field_id' => $field_id,
    'field_value' => $field_value,
    'content' => $content,
    'row' => $row,
));
