<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'
) {
    exit();
}
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();

require_once '../class.php';

$timeconfig = SetUp::getConfig('default_timezone');
$timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
date_default_timezone_set($timezone);

require_once '../users/users.php';
global $_USERS;

if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = SetUp::getConfig("lang");
}
require "../translations/".$lang.".php";

if (file_exists('../users/users-new.php')) {
    include '../users/users-new.php';
} else {
    $newusers = array();
}

$encodeExplorer = new EncodeExplorer();
$updater = new Updater();

$setfrom = SetUp::getConfig('email_from');

if ($setfrom == null) {
    echo $encodeExplorer->getString("setup_email_application")."<br>";
    exit();
}

$postname = filter_input(
    INPUT_POST, "user_name", FILTER_SANITIZE_STRING
);
$postpass = filter_input(
    INPUT_POST, "user_pass", FILTER_SANITIZE_STRING
);
$postpassconfirm = filter_input(
    INPUT_POST, "user_pass_confirm", FILTER_SANITIZE_STRING
);
$postmail = filter_input(
    INPUT_POST, "user_email", FILTER_VALIDATE_EMAIL
);

if (!$postname 
    || !$postmail
    || !$postpass 
    || !$postpassconfirm
) {
    echo '<div class="alert alert-warning" role="alert">'.$encodeExplorer->getString("fill_all_fields").'</div>';
    exit();
}

$postname = preg_replace('/\s+/', '', $postname);

if (strlen($postname) < 3) {
    echo '<div class="alert alert-danger" role="alert">'.$encodeExplorer->getString("minimum").'3 chars</div>';
    exit();
}
if ($postpass !== $postpassconfirm) {
    echo '<div class="alert alert-danger" role="alert">'.$encodeExplorer->getString("passwords_dont_match").'</div>';
    exit();
}

if ($updater->findUser($postname) 
    || $updater->findUserPre($postname)
) {
    echo '<div class="alert alert-danger" role="alert"><strong>'.$postname.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
    exit();
}

// if is already an active user
if ($updater->findEmail($postmail)) {
    echo '<div class="alert alert-warning" role="alert"><strong>'.$postmail.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
    exit();
}
// if is already on pre-registration
if ($updater->findEmailPre($postmail)) {
    echo '<div class="alert alert-warning" role="alert"><strong>'.$postmail.'</strong> '.$encodeExplorer->getString("file_exists").'</div>';
}

$newuser = array();

$newuser['name'] = $postname;
$salt = SetUp::getConfig('salt');
$newuser['pass'] = crypt($salt.urlencode($postpass), Utils::randomString());
$newuser['email'] = $postmail;
$date = date("Y-m-d", time());
$newuser['date'] = $date;

$activekey = md5($postname.$salt.$date);
$newuser['key'] = $activekey;

$appurl =  SetUp::getConfig('script_url');
$activationlink = $appurl."?act=".$activekey;

array_push($newusers, $newuser);

require '../mail/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';

if (SetUp::getConfig('smtp_enable') == true) {

    $mail->isSMTP();
    $mail->SMTPDebug = 0; // 1 = errors and messages

    $smtp_auth = SetUp::getConfig('smtp_auth');

    $mail->Host = SetUp::getConfig('smtp_server');
    $mail->Port = (int)SetUp::getConfig('port');

    if (SetUp::getConfig('secure_conn') !== "none") {
        $mail->SMTPSecure = SetUp::getConfig('secure_conn');
    }
    
    $mail->SMTPAuth = $smtp_auth;

    if ($smtp_auth == true) {
        $mail->Username = SetUp::getConfig('email_login');
        $mail->Password = SetUp::getConfig('email_pass');
    }
}
$mail->setFrom($setfrom, SetUp::getConfig('appname'));
$mail->addAddress($postmail, '<'.$postmail.'>');

$mail->Subject = SetUp::getConfig('appname').": ".$encodeExplorer->getString('activate_account');

$altmessage = $encodeExplorer->getString('follow_this_link_to_activate')."/n"
    .$activationlink;

$mail->AddEmbeddedImage('../mail/mail-logo.png', 'logoimg', 'mail/mail-logo.png');

// Retrieve the email template required
$message = file_get_contents('../mail/template/template-activate-account.html');

// Replace the % with the actual information
$message = str_replace('%app_url%', $appurl, $message);
$message = str_replace('%app_name%', SetUp::getConfig('appname'), $message);

$message = str_replace(
    '%translate_follow_this_link_to_activate%', 
    $encodeExplorer->getString('follow_this_link_to_activate'), $message
);
$message = str_replace(
    '%activation_link%', 
    $activationlink, $message
);
$message = str_replace(
    '%translate_activate%', 
    $encodeExplorer->getString('activate'), $message
);

$message = str_replace(
    '%translate_username%', 
    $encodeExplorer->getString('username').": <strong>".$postname."<strong>", $message
);

$mail->msgHTML($message);

$mail->AltBody = $altmessage;

if (!$mail->send()) {
    echo '<div class="alert alert-danger" role="alert">Mailer Error: ' . $mail->ErrorInfo.'</div>';
} else {
    if ($updater->updateRegistrationFile($newusers, "../users/")) {
        echo '<div class="alert alert-success" role="alert">'.$encodeExplorer->getString('activation_link_sent').'</div>';   
    } else {
        echo '<div class="alert alert-danger" role="alert"><strong>users-new</strong> file update failed</div>';
    }
}
exit;