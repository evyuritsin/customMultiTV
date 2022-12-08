<?php

class multiTvDbClass
{
    public function __construct($language, $params = [])
    {
        self::render('main', $params);
    }

    public static function render($templateName, $variablesArray = [])
    {
        $templatePath = self::findTemplateFile($templateName);

        if ($templatePath) {
            echo self::renderTemplateFile($templatePath, $variablesArray);
        }

        return;
    }

    protected static function findTemplateFile($templateName)
    {
        $templatePath = MULTITVDB_BASE_PATH . 'templates/' . $templateName . '.template.php';

        if (file_exists($templatePath) and is_file($templatePath)) {
            return $templatePath;
        }

        return false;
    }

    protected static function renderTemplateFile($templatePath, $variablesArray = [])
    {
        if (is_array($variablesArray) and !empty($variablesArray)) {
            extract($variablesArray);
        }

        ob_start();
        ob_implicit_flush(false);

        include($templatePath);

        return ob_get_clean();
    }

    public static function connectAssetJs($assetName, $version = false)
    {
        return '<script src="' . self::getAssetPath($assetName, $version) . '" type="text/javascript"></script>';
    }

    public static function connectAssetCss($assetName, $version = false)
    {
        return '<link href="' . self::getAssetPath($assetName, $version) . '" rel="stylesheet" type="text/css" />';
    }

    protected static function getAssetPath($assetName, $version = false)
    {
        $path = $assetName;

        if ($version) {
            $path .= '?v=' . $version;
        }

        return $path;
    }
    public static function getfieldsData($settings) {
        foreach ($settings as $value) 
            $output[] = $value['key'];
        return $output;
    }
    public static function getfields($settings, $data, $id_doc, $id_tv, $value_tv) {
        global $modx;
        while( $row = $modx->db->getRow( $data ) ) {  
            foreach ($settings as $block) {
                $rand = rand(1000, 1000000);
                if (empty($row[$block['key']]) and isset($block['default'])) { 
                    $valueField = $block['default']; 
                } elseif ( !empty( $row[$block['key']] ) ) {
                    $valueField = $row[$block['key']]; 
                }
                switch ($block['type']) {
                    case 'text':
                    case 'textarea':
                        $output .= self::getTplUI($block['type'], 
                            array(
                                'id' => $id_doc, 
                                'value' => $valueField, 
                                'caption' => $block['caption'],
                                'type' => $block['type'],
                                'field' => $block['key'],
                                'rand' => $rand
                            )
                        );
                        break;
                    case 'select':
                        $selectItem = explode('||', $block['list']);
                        foreach ($selectItem as $sItem) {
                            $keyValue = explode('==', $sItem);
                            if (empty($row[$block['key']])) {
                                if ($block['default'] == $keyValue[1]) { $selected = 'selected'; } else { $selected = ''; }
                            } else {
                                if ($row[$block['key']] == $keyValue[1]) { $selected = 'selected'; } else { $selected = ''; }
                            }
                            
                            $list .= '<option '. $selected. ' value="'. $keyValue[1] . '">'. $keyValue[0] . '</option>';

                        }
                        $output .= self::getTplUI($block['type'], 
                            array(
                                'id' => $id_doc, 
                                'value' => $valueField, 
                                'caption' => $block['caption'],
                                'type' => $block['type'],
                                'field' => $block['key'],
                                'list' => $list,
                                'rand' => $rand
                            )
                        );
                        break;                        
                    default:
                        $output .= self::getTplUI($block['type'], 
                            array(
                                'id' => $id_doc, 
                                'value' => $row[$block['key']], 
                                'caption' => $block['caption'],
                                'type' => $block['type'],
                                'field' => $block['key'],
                                'rand' => $rand
                            )
                        );
                }
            }
            $tplItem .= self::getTplUI('item', array('fields' => $output, 'id_row' => $row['id']));
            unset($output);
        }
        $tplCont = self::getTplUI('conteiner', array('wrapper' => $tplItem, 'id_doc' => $id_doc, 'id_tv' => $id_tv, 'value_tv' => $value_tv));
        return $tplCont;
    }

    public static function getAddNewItem($settings) {
        foreach ($settings as $block) {
            switch ($block['type']) {
                case 'text':
                case 'textarea':
                    $output .= self::getTplUI($block['type'], 
                        array(
                            'id' => $id_doc, 
                            'value' => $row[$block['key']], 
                            'caption' => $block['caption'],
                            'type' => $block['type'],
                            'field' => $block['key']
                        )
                    );
                    break;
                default:
                    $output .= self::getTplUI($block['type'], 
                        array(
                            'id' => $id_doc, 
                            'value' => $row[$block['key']], 
                            'caption' => $block['caption'],
                            'type' => $block['type'],
                            'field' => $block['key']
                        )
                    );
            }
        }
        return addslashes( self::getTplUI('item', array('fields' => $output, 'id_row' => '0')) );
    }

    public static function getTVName($idTV) {
        global $modx;

        $name = $modx->db->getValue( $modx->db->select("name", $modx->getFullTableName('site_tmplvars'),  "id='" . $idTV ."'") );

        return $name;
    }
    public static function getTplUI($name, $replace) {
        $content = file_get_contents(MULTITVDB_BASE_PATH . 'templates/UI/'. $name. '.tpl.php', true);
        foreach ($replace as $key => $value) {
            $content = str_replace('[+'. $key. '+]', $value, $content);
        }
      return $content;
    }
    public static function getData($tablename, $id_doc, $id_tv, $field_id_doc, $field_id_tv, $fields) {
        global $modx;
        $fields[] = 'id';
        $fields_list = implode(',', $fields);
        $data = $modx->db->select($fields_list, $modx->getFullTableName($tablename),  $field_id_doc. "='" . $id_doc ."' AND ". $field_id_tv. "='". $id_tv. "'");
        return $data;
    }     

}
