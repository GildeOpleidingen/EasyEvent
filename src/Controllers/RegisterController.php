<?php

namespace App\Controllers;

use App\Controller;
use App\Models\RegisterModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends Controller
{
    private $model;

    public function index()
    {
        session_start();

        if (isset($_SESSION['verificationCode'])) {
            $this->render('register', ['step' => 'verify']); 
        } else {
            $this->render('register'); 
        }
    }
    // functie om te registreren
    public function register()
{
    session_start();

    $voornaam = trim($_POST['voornaam']);
    $achternaam = trim($_POST['achternaam']);
    $telefoon = trim($_POST['telefoon']);
    $email = trim($_POST['email']);
    $wachtwoord = trim($_POST['wachtwoord']);
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $rol = trim($_POST['rol']);
    $herhaalWachtwoord = trim($_POST['herhaalWachtwoord']);

    // Controleer of alle velden ingevuld zijn
    if (empty($voornaam) || empty($achternaam) || empty($email) || empty($wachtwoord) || empty($telefoon) || empty($herhaalWachtwoord)) {
        $this->render('register', ['error' => 'Alle velden zijn verplicht.']);
        return;
    }

    // Controleer of de wachtwoorden overeenkomen
    if ($wachtwoord !== $herhaalWachtwoord) {
        $this->render('register', ['error' => 'Wachtwoorden komen niet overeen.']);
        return;
    }

    // Controleer of de gebruiker al bestaat
    $this->model = new RegisterModel();
    if ($this->model->userExists($email)) {
        $this->render('register', ['error' => 'Er is al een gebruiker met dit e-mailadres.']);
        return;
    }

    // Sla de gegevens tijdelijk op in de sessie
    $_SESSION['register_data'] = [
        'voornaam' => $voornaam,
        'achternaam' => $achternaam,
        'telefoon' => $telefoon,
        'email' => $email,
        'wachtwoord' => $wachtwoord,
        'gebruikersnaam' => $gebruikersnaam,
        'rol' => $rol
    ];

    // Genereer en verstuur verificatiecode
    $verificationCode = $this->generateVerificationCode();
    $_SESSION['verificationCode'] = $verificationCode;

    if ($this->verifyEmail($email, $verificationCode)) {
        $this->render('register', ['succes' => 'Gebruiker is geregistreerd, een verificatiecode is verzonden.', 'step' => 'verify']);
    } else {
        $this->render('register', ['error' => 'E-mailverificatie is mislukt.']);
    }
}



    // Functie om 6 cijferige code te genereren
    public function generateVerificationCode($length = 6)
    {
        $characters = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public function userExists($email)
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // functie om email te sturen met de verificatiecode
    public function verifyEmail($email, $verificationCode)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gilde.easyevents@gmail.com';
            $mail->Password = 'wiqabusqxmeeavnv';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('gilde.easyevents@gmail.com', 'Mailer');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verificatiecode';
            $mail->Body = "Uw verificatiecode is: $verificationCode";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    // functie om verificatie code te checken
    public function verifyCode()
{
    session_start();

    $enteredCode = trim($_POST['verificationCode']);
    $verificationCode = $_SESSION['verificationCode'] ?? '';

    if ($enteredCode === $verificationCode) {
        $registerData = $_SESSION['register_data'] ?? null;

        if ($registerData) {
            $this->model = new RegisterModel();
            $this->model->register(
                $registerData['voornaam'],
                $registerData['achternaam'],
                $registerData['telefoon'],
                $registerData['email'],
                $registerData['wachtwoord'],
                $registerData['gebruikersnaam'],
                $registerData['rol']
            );

            unset($_SESSION['register_data']);
            unset($_SESSION['verificationCode']);

            $this->render('register', ['succes' => 'Verificatie geslaagd! Je kunt nu inloggen.']);
        } else {
            $this->render('register', ['error' => 'Er is een probleem met je registratiegegevens.']);
        }
    } else {
        $this->render('register', ['error' => 'Verkeerde code. Probeer het opnieuw.', 'step' => 'verify']);
    }
}

}
