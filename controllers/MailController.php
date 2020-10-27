<?php
require 'function.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (Object)Array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "email":
            $mail= new PHPMailer(true);
            //$mail->SMTPDebug=SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            try {
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Port = 465;
                $mail->SMTPSecure = "ssl";
                $mail->Username = "waw4613@gmail.com";
                $mail->Password = "Tifjq94101#";
                $mail->CharSet = 'utf-8';
                $mail->Encoding = "base64";

                $mail->From="waw4613@gmail.com";
                $mail->FromName="parkwon";
                $mail->AddAddress("waw4613@gmail.com","joon");

                $mail->isHTML(true);
                $mail->Subject = 'Here is the subject';
                $mail->Body = '왜 지메일은 안될까요??';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->Send();
                echo("Message has been sent");
            }catch(phpmailerException $e) {
                echo $e->errorMessage();
            }catch(Exception $e) {
                echo $e->getMessage();
            }
    }
} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}