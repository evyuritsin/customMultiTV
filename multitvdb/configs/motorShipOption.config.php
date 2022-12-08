<?php
$settings['display'] = 'vertical';
$settings['fields'] = array(
    array(
    	'key' => 'title',
        'caption' => 'Значение',
        'type' => 'textarea'
    ),
    array(
        'key' => 'icon',
        'caption' => 'Иконка',
        'type' => 'image'
    ),          
);
$settings['configuration'] = array(
    'table_name' => 'main_excursions',//имя таблицы без префикса
    'field_id_doc' => 'id_doc',//название поля id документа
    'field_id_tv' => 'id_tv'//название поля id tv поля
);