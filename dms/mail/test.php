<?php

/**
 * This example shows sending a message using PHP's mail() function.
 */

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../functions/phpmailer/vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = 0;
$mail->IsSMTP();
$mail->Host = "smtp.dev.x10.bz";
$mail->Port = 465;
// optional
// used only when SMTP requires authentication
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
$mail->Username = 'noreply@dev.x10.bz';
$mail->Password = 'YKo7KIaH8P';


//Set who the message is to be sent from
$mail->setFrom('noreply@dev.x10.bz', 'eFileCabinet');
//Set an alternative reply-to address
$mail->addReplyTo('noreply@dev.x10.bz', 'eFileCabinet');
//Set who the message is to be sent to
$mail->addAddress($email);
//This should be the same as the domain of your From address
$mail->DKIM_domain = 'dev.x10.bz';
//See the DKIM_gen_keys.phps script for making a key pair -
//here we assume you've already done that.
//Path to your private key:
$mail->DKIM_private = 'smtp._domainkey.dev.x10.bz.pem';
//Set this to your own selector
$mail->DKIM_selector = 'smtp';
//Put your private key's passphrase in here if it has one
$mail->DKIM_passphrase = '';
//The identity you're signing as - usually your From address
$mail->DKIM_identity = $mail->From;
//Set the subject line
$mail->Subject = $action;
ob_start();
if($action=='Email Verification'){
  include "verification.php";
}elseif ($action=='Password Reset') {
  include "reset.php";
}elseif($action=='New File'){
  include "update.php";
}
$myvar = ob_get_clean();
$mailContent = $myvar;
$mail->Body = $mailContent;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('../mail/verification.php'), __DIR__);
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
// $mail->addAttachment('../mail/images/phpmailer.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

?>
