<style>
.cmtv__conteiner {
    position: relative;
    width: 100%;
    height: fit-content;
    padding: 20px;
    border: 1px solid #d4d4d4;
    border-radius: 10px;
    margin-top: 10px;
}
.cmtv__item {
    position: relative;
    width: 100%;
    height: fit-content!important;
    border: 1px solid #d4d4d4;
    border-radius: 10px;
    padding: 20px 10px 10px 10px;
    margin-bottom: 10px;  
}
.cmtv__item i, .cmtv__conteiner i {
    position: absolute;
    top: -7px;
    cursor: pointer;
}
.cmtv__add-item {
    right: 60px;
}
.cmtv__dell-item {
    right: 40px;
}
.cmtv__copy-item {
    right: 20px;
}
.cmtv_input {
    float: none!important;
    margin-top: 5px!important;
}
.cmtv_col {
    display: flex;
    align-items: baseline;
}
.flex-1 { flex: 1; }
.flex-2 { flex: 2; }
.flex-3 { flex: 3; }
.flex-4 { flex: 4; }
.flex-5 { flex: 5; }
.flex-6 { flex: 6; }
.flex-7 { flex: 7; }
.flex-8 { flex: 8; }
.flex-9 { flex: 9; }
.flex-10 { flex: 10; }

.ml-5 { margin-left: 5px; }
.ml-10 { margin-left: 10px; }
.ml-15 { margin-left: 15px; }
.ml-20 { margin-left: 20px; }
.ml-25 { margin-left: 25px; }
.ml-30 { margin-left: 30px; }
.ml-35 { margin-left: 35px; }
.ml-40 { margin-left: 40px; }

</style>
<?

global $modx;
global $content;
multiTvDbClass::connectAssetJs('/admin/media/script/jquery/jquery.min.js');
multiTvDbClass::connectAssetCss(MULTITVDB_BASE_PATH . 'assets/styles/style.css');
if (multiTvDbClass::checkConfigFile($field_id) == 'true') {
    $tvName = multiTvDbClass::getTVName($field_id);
    include_once(MULTITVDB_BASE_PATH . 'configs/'. $tvName. '.config.php');
} else {
    echo multiTvDbClass::checkConfigFile($field_id);
    return;
}
$tablename = $settings['configuration']['table_name'];
$field_id_doc = $settings['configuration']['field_id_doc'];
$field_id_tv = $settings['configuration']['field_id_tv'];
$fields = multiTvDbClass::getfieldsData($settings['fields']); 
//echo multiTvDbClass::checkTableDB($tablename, $fields);
//return;
if (multiTvDbClass::checkTableDB($tablename, $fields) == 'true') {
    $data = multiTvDbClass::getData($tablename, $content['id'], $field_id, $field_id_doc, $field_id_tv, $fields);
    echo multiTvDbClass::getfields($settings['fields'], $data, $content['id'], $field_id, $field_value);
} else {
    echo multiTvDbClass::checkTableDB($tablename, $fields);
    return;
}


//echo '<pre>';

//print_r($modx->db->getRow( $data ));
//echo '</pre>';
?>
<!--input type="text" name="tv<?= $field_id; ?>" id="tv<?= $field_id; ?>" /-->

<?= 
multiTvDbClass::connectAssetJs(MULTITVDB_BASE_PATH . 'assets/scripts/script.js');
?>
<script>
    $(document).ready(function() {

        function getJson(target) {
            var conteiner = target.closest('.cmtv__conteiner');
            var items = conteiner.find('.cmtv__item');
            var els = [];
            const object = {
                id_doc: conteiner.attr('id_doc'),
                id_tv: conteiner.attr('id_tv'),
                value: {}
            };
            items.each(function (index, el){
                var input = {};
                var element = [];
                var output = {id_row: $(el).attr('id_row'), value: {}};
                var item = $(el).find('.cmtv_input');
                item.each(function (index1, el1){
                    input['type'] = $(el1).attr('tvtype');
                    input['field'] = $(el1).attr('fieldtable');
                    input['value'] = $(el1).val();
                    element.push(input);
                    input = {};
                });
                output['value'] = element;
                els.push(output);
                output = [];
            });
            object['value'] = els;
            els = [];
            $('#tv' + conteiner.attr('id_tv')).val(JSON.stringify(object));
            $('.cmtv_input').on( "change", function() {
                getJson($(this));
            });
            //eventsBtns();
        }
        function eventsBtns() {
            $('.cmtv__item .cmtv__add-item').on( "click", function() {
                $(this).closest('.cmtv__item').prepend( $(this).closest('.cmtv__item').clone() ).attr('id_row', '0').find('.cmtv_input').val('');
                //$(this).closest('.cmtv__item').clone().prependTo( $(this).closest('.cmtv__item') ).attr('id_row', '0').find('.cmtv_input').val('');
                getJson($(this));
                $('.cmtv__item .cmtv__dell-item').on( "click", function() {
                    var count = $(this).closest('.cmtv__conteiner').find('.cmtv__item').length;
                    if (count > 1) {
                        $(this).closest('.cmtv__item').remove();
                    } else {
                        $(this).closest('.cmtv__conteiner').find('.cmtv__item').attr('id_row', '0').find('.cmtv_input').val('');
                    }
                    getJson($(this));
                });                 
            });
            $('.cmtv__conteiner .cmtv__add-item').on( "click", function() {
                $(this).closest('.cmtv__conteiner').find('.cmtv__item').first().clone().prependTo( $(this).closest('.cmtv__conteiner') ).attr('id_row', '0').find('.cmtv_input').val('');
                getJson($(this)); 
                $('.cmtv__item .cmtv__dell-item').on( "click", function() {
                    var count = $(this).closest('.cmtv__conteiner').find('.cmtv__item').length;
                    if (count > 1) {
                        $(this).closest('.cmtv__item').remove();
                    } else {
                        $(this).closest('.cmtv__conteiner').find('.cmtv__item').attr('id_row', '0').find('.cmtv_input').val('');
                    }
                    getJson($(this));
                });                               
            });        
            $('.cmtv__item .cmtv__dell-item').on( "click", function() {
                var count = $(this).closest('.cmtv__conteiner').find('.cmtv__item').length;
                if (count > 1) {
                    $(this).closest('.cmtv__item').remove();
                } else {
                    $(this).closest('.cmtv__conteiner').find('.cmtv__item').attr('id_row', '0').find('.cmtv_input').val('');
                }
                getJson($(this));
            });
            $('.cmtv__item .cmtv__copy-item').on( "click", function() {
                console.log('copy');
            });            
        }
        eventsBtns();

        $('.cmtv_input').on( "change", function() {
            getJson($(this));
        });              
    });
</script>