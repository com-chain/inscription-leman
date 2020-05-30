<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';


$how_to_file ="./resources/2020_Biletujo_Marche_a_suivre_creation_compte.pdf";


function getBody($name, $type) {
    return 'Bonjour '.$name.'<br/> ';
}

function getAltBody($name, $type) {
    return 'Bonjour '.$name.'';
}


function sendConfirmationMail($to_address, $code_file, $name, $type) {
$from_address = 'ne-pas-repondre@monnaie-leman.org'; 
$from_name = 'Ne pas repondre - Monnaie Leman';  

$host = "myMailHost";
$host_login = $from_address;
$host_password = "myMailPassword";

$code_file_name ="Leman_electronique_Code_autorisation.pdf";
$how_to_file ="./resources/2020_Biletujo_Marche_a_suivre_creation_compte.pdf";
$how_to_file_name ="Marche_a_suivre_creation_compte.pdf";
$subject = "Monnaie Léman - Instructions pour créer votre compte électronique";



    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    // Enable verbose debug output
        $mail->isSMTP();                           
        $mail->Host       = $host;                   
        $mail->SMTPAuth   = true;                 // Enable SMTP authentication
        $mail->Username   = $host_login;                    
        $mail->Password   = $host_password;                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // for TLS =>  PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;                           // for TLS =>  587

        //Recipients
        $mail->setFrom($from_address, $from_name);
        $mail->addAddress($to_address);               // Name is optional
        // $mail->addReplyTo('reply@example.com', 'Name');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        $mail->addAttachment($code_file, $code_file_name, 'base64', 'application/pdf');         
        $mail->addAttachment($how_to_file, $how_to_file_name, 'base64', 'application/pdf');    

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = getBody($name, $type);
        $mail->AltBody = getAltBody($name, $type);

        $mail->send();
    } catch (Exception $e) {
        throw new Exception('Mail Error :'.$mail->ErrorInfo);
    }

}

?>
