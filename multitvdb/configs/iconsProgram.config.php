<?php
$settings['display'] = 'vertical';
$settings['fields'] = array(
    array(
    	'key' => 'title',
        'caption' => 'Значение',
        'type' => 'text'
    ),
    array(
    	'key' => 'description',
        'caption' => 'Описание',
        'type' => 'textarea'
    ),
    array(
        'key' => 'image',
        'caption' => 'Изображение',
        'type' => 'image'
    ),
    /*
    array(
        'key' => 'age',
        'caption' => 'Возраст',
        'type' => 'select',
        'list' => 'До 7 лет==1||От 7 до 14 лет==2||От 14 лет и старше==3',
        'default' => '2'
    ),
    */
    array(
        'key' => 'age',
        'caption' => 'Возраст',
        'type' => 'number',
        'default' => '2'
    ),    
    array(
        'key' => 'date',
        'caption' => 'Дата создания',
        'type' => 'date'
    ),           
);
$settings['configuration'] = array(
    'table_name' => 'main_hotels',//имя таблицы без префикса
    'field_id_doc' => 'id_doc',//название поля id документа
    'field_id_tv' => 'id_tv'//название поля id tv поля
);