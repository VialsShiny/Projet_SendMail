<!DOCTYPE html>
<html lang='FR-fr'>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>SendMail Project</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name='description' content='Projet SendMail'>
    <link rel='stylesheet' type='text/css' media='screen' href='./assets/css/normalize.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='./assets/css/style.css'>
</head>

<body>
<h1>Contactez-nous</h1>
<form method="post" action="">
    <label>Votre email</label>
    <input type="email" name="email" required>
    <label>Message</label>
    <textarea name="message" required></textarea>
    <input type="submit" value="Envoyer">
</form>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mailFrom = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $messageUser = htmlspecialchars(trim($_POST['message']));
    $debug = false; // Set to true only for debugging

    try {
        // Créer une instance de classe PHPMailer
        $mail = new PHPMailer($debug);

        // Si le débogage est activé
        if ($debug) {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Journal détaillé
        }

        // Authentification via SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.example.com"; // Remplacez par votre hôte SMTP (ex: smtp.gmail.com)
        $mail->Port = 587; // Utilisez 465 pour SSL
        $mail->Username = "xinotop916@chysir.com"; // Votre adresse email
        $mail->Password = "your_password"; // Votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // Configuration de l'expéditeur et du destinataire
        $mail->setFrom('xinotop916@chysir.com', 'Nom');
        $mail->addAddress($mailFrom, 'User');

        // Ajouter une pièce jointe si nécessaire
        // $attachmentPath = "/path/to/your/file.png"; // Assurez-vous que le chemin est correct
        // if (file_exists($attachmentPath)) {
        //     $mail->addAttachment($attachmentPath, "file.png");
        // }

        // Configuration du contenu de l'email
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->Subject = 'Suivi';
        $mail->Body = $messageUser;

        // Envoi de l'email
        if ($mail->send()) {
            echo '<p>Votre message a bien été envoyé.</p>';
        } else {
            echo '<p>Erreur lors de l\'envoi de votre message: ' . $mail->ErrorInfo . '</p>';
        }
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur de l'expéditeur: " . $e->getMessage();
    }
}
?>
</body>
</html>
