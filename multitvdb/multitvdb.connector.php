<?php

if (is_file(MODX_BASE_PATH . 'assets/cache/siteManager.php')) {
    include_once(MODX_BASE_PATH . 'assets/cache/siteManager.php');
}

if (!defined('MGR_DIR') && is_dir(MODX_BASE_PATH . 'manager')) {
    define('MGR_DIR', 'manager');
}

global $language;

// Include the nessesary files
define('MODX_MANAGER_PATH', $base_path . MGR_DIR . '/');
//require_once(MODX_MANAGER_PATH . 'includes/config.inc.php');
//require_once(MODX_MANAGER_PATH . 'includes/protect.inc.php');

// Setup the MODx API
define('MODX_API_MODE', true);
define('IN_MANAGER_MODE', true);

//start session
//startCMSSession();

// initiate a new document parser
include_once(MODX_MANAGER_PATH . '/includes/document.parser.class.inc.php');
$modx = new DocumentParser;

// provide the MODx DBAPI
$modx->db->connect();

// provide the $modx->documentMap and user settings
$modx->getSettings();

// set geo (base) path
define('MULTITVDB_PATH', str_replace(MODX_BASE_PATH, '', str_replace('\\', '/', realpath(dirname(__FILE__)))) . '/');
define('MULTITVDB_BASE_PATH', MODX_BASE_PATH . MULTITVDB_PATH);

// include classfile
if (!class_exists('GeoClass')) {
    include(MULTITVDB_BASE_PATH . 'classes/multitvdb.class.php');
}

$languageName = 'english';
if (file_exists(MULTITVDB_BASE_PATH . 'languages/' . $modx->config['manager_language'] . '.language.php')) {
    $languageName = $modx->config['manager_language'];
}
include(MULTITVDB_BASE_PATH . 'languages/' . $languageName . '.language.php');
