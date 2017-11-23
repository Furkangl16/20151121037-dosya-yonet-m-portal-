<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'
) {
    exit();
}
require_once '../class.php';
require_once '../users/users.php';
global $_USERS;

if (file_exists('../users/users-new.php')) {
    include '../users/users-new.php';
} else {
    $newusers = array();
}
global $newusers;
$updater = new Updater();

//check we have username post var
$postname = filter_input(
    INPUT_POST, "user_name", FILTER_SANITIZE_STRING
);
if ($postname) {

    $postname = preg_replace('/\s+/', '', $postname);

    if ($updater->findUser($postname) || $updater->findUserPre($postname)) {
        //echo '<i class="fa fa-times text-danger fa-fw">';
        echo 'error';
    } else {
        //echo '<i class="fa fa-check text-success fa-fw">';
        echo 'success';
    }
}    
exit();