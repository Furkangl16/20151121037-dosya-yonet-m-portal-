<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'
) {
    exit();
}
require_once '../mail/PHPMailerAutoload.php';
require '../config.php';
session_name($_CONFIG["session_name"]);
session_start();
require '../users/users.php';
require '../class.php';

$lang = filter_input(INPUT_POST, 'thislang', FILTER_SANITIZE_STRING);
require '../translations/'.$lang.'.php';

if (isset($_POST['senduser'])) {

    $encodeExplorer = new EncodeExplorer();

    $setfrom = SetUp::getConfig('email_from');

    if ($setfrom == null) {
        echo $encodeExplorer->getString("setup_email_application")."<br>";
        exit();
    }

    $timeconfig = SetUp::getConfig('default_timezone');
    $timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
    date_default_timezone_set($timezone);

    $path = urldecode($_POST['path']);
    $appname = SetUp::getConfig('appname');
    $time = SetUp::formatModTime(time());

    $appurl = SetUp::getConfig('script_url');

    $title = "NEW UPLOAD on ".$appname;

    $name = GateKeeper::getUserInfo('name');

    $altmessage = $time."\n\n";
    $altmessage .= $appurl."\n\n";
    $altmessage .= "FROM : ".$name."\n\n";

    $upfiles = $time."<br><ul>";

    foreach ($_POST['filename'] as $filename) {
        $upfiles .= "<li> : ".$path.$filename."</li>";
        $altmessage .= "FILE : ".$path.$filename."\n";
    }

    $upfiles .= "</ul>";

    if (SetUp::getConfig('smtp_enable') == true) {

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->SMTPDebug = 1;

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

    $mail->setFrom($setfrom, $appname);
    $mail->Subject = $title;

    $mail->AddEmbeddedImage('../mail/mail-logo.png', 'logoimg', 'mail/mail-logo.png');

    // Retrieve the email template required
    $message = file_get_contents('../mail/template/template-uploaded-files.html');

    $message = str_replace('%app_url%', $appurl, $message);
    $message = str_replace('%app_name%', $appname, $message);
    $message = str_replace('%translate_from%', $encodeExplorer->getString('from'), $message);
    $message = str_replace('%username%', $name, $message);
    $message = str_replace('%upfiles%', $upfiles, $message);
    
    $mail->msgHTML($message);

    $mail->AltBody = $altmessage;

    // send notification mail to each selected user
    foreach ($_POST['senduser'] as $senduser) {

        $mail->addAddress($senduser, '<'.$senduser.'>');
        // $mail->send();
        if (!$mail->send()) {
            echo "error sending mail";
        }

        $mail->ClearAddresses();
    }

    // // send notification mail to the uploader user
    // $mail->addAddress(GateKeeper::getUserInfo('email'), '<'.GateKeeper::getUserInfo('email').'>');
    // $mail->send();
    // $mail->ClearAddresses();
}