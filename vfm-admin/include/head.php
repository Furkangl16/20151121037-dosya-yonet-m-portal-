<?php

require_once 'vfm-admin/config.php';
require_once 'vfm-admin/users/users.php';
require_once 'vfm-admin/class.php';

$timeconfig = SetUp::getConfig('default_timezone');
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

global $_ERROR;
global $_WARNING;
global $_SUCCESS;


if ($_CONFIG["firstrun"] === true) {
    header('Location:vfm-admin/login.php');
    exit();  
}

global $_IMAGES;
global $_USERS;
global $_DLIST;

require_once 'vfm-admin/users/remember.php';
global $_REMEMBER;
$cookies = new Cookies();

$encodeExplorer = new EncodeExplorer();
$encodeExplorer->init();

require_once 'vfm-admin/translations/'.$encodeExplorer->lang.'.php';
global $_TRANSLATIONS;

$translations_index = json_decode(file_get_contents('vfm-admin/translations/index.json'), true);
global $translations_index;

$gateKeeper = new GateKeeper();
$gateKeeper->init();
$setUp = new SetUp();
$location = new Location();
$location->init();
$downloader = new Downloader();
$updater = new Updater();
$updater->init();
$template = new Template();

require_once 'vfm-admin/users/token.php';
global $_TOKENS;
$resetter = new Resetter();
$resetter->init();

if ($gateKeeper->isAccessAllowed()) {
    $fileManager = new FileManager();
    $fileManager->run($location);
    $encodeExplorer->run($location);
};

unset($_SESSION['upcoda']);
$_SESSION['upcoda'] = array();

unset($_SESSION['uplist']);
$_SESSION['uplist'] = array();

if (!isset($_GET['response'])) {
    if (isset($_ERROR) && strlen($_ERROR) > 0 ) {
        $_SESSION['error'] = $_ERROR;
    }
    if (isset($_SUCCESS) && strlen($_SUCCESS) > 0 ) {
        $_SESSION['success'] = $_SUCCESS;
    }
    if (isset($_WARNING) && strlen($_WARNING) > 0 ) {
        $_SESSION['warning'] = $_WARNING;
    }
} 

if (isset($_SESSION['error'])) {
    $_ERROR = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    $_SUCCESS = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['warning'])) {
    $_WARNING = $_SESSION['warning'];
    unset($_SESSION['warning']);
}

if (isset($_SESSION['vfm_dlist'])) {
    $_DLIST = $_SESSION['vfm_dlist'];
} else {
    $_DLIST = $setUp->getConfig('folderdeforder');
}

$uid = md5(uniqid(mt_rand()));

$getrp = filter_input(INPUT_GET, "rp", FILTER_SANITIZE_STRING);
$getreg = filter_input(INPUT_GET, "reg", FILTER_SANITIZE_STRING);
$regactive = filter_input(INPUT_GET, "act", FILTER_SANITIZE_STRING);

$getusr = filter_input(INPUT_GET, "usr", FILTER_SANITIZE_STRING);
$getfilelist = filter_input(INPUT_GET, "dl", FILTER_SANITIZE_STRING);

require_once 'vfm-admin/vfm-icons.php';