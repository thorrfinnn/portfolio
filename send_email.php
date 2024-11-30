<?php
// Inclure Composer Autoloader
require 'vendor/autoload.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $comment = htmlspecialchars($_POST['comment']);

    // Vérification de l'adresse email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Créer une instance de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Paramètres du serveur SMTP Gmail
            $mail->isSMTP();  // Utiliser SMTP
            $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
            $mail->SMTPAuth = true;  // Authentification SMTP
            $mail->Username = 'votre-email@gmail.com';  // Remplacez par votre adresse email Gmail
            $mail->Password = 'votre-mot-de-passe';  // Remplacez par votre mot de passe (ou mot de passe d'application si l'authentification à 2 facteurs est activée)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Cryptage TLS
            $mail->Port = 587;  // Port SMTP de Gmail (587)

            // Expéditeur et destinataire
            $mail->setFrom($email, $name);  // L'email de l'utilisateur (expéditeur)
            $mail->addAddress('saadjdoua11@gmail.com');  // Votre adresse email où recevoir les messages

            // Contenu de l'email
            $mail->isHTML(false);  // Utiliser le format texte brut
            $mail->Subject = "Message de contact de $name";
            $mail->Body = "Nom: $name\nEmail: $email\nMessage: $comment\n";  // Contenu du message

            // Envoi de l'email
            if ($mail->send()) {
                echo "Votre message a été envoyé avec succès!";
            } else {
                echo "Désolé, l'envoi de votre message a échoué.";
            }
        } catch (Exception $e) {
            // Si une exception se produit lors de l'envoi de l'email
            echo "Erreur lors de l'envoi: {$mail->ErrorInfo}";
        }
    } else {
        echo "L'adresse email fournie n'est pas valide.";
    }
}
?>
