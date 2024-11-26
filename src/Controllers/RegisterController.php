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
        $this->render('register');
    }

    public function register()
    {
        $voornaam = trim($_POST['voornaam']);
        $achternaam = trim($_POST['achternaam']);
        $telefoon = trim($_POST['telefoon']);
        $email = trim($_POST['email']);
        $wachtwoord = trim($_POST['wachtwoord']);
        $gebruikersnaam = trim($_POST['gebruikersnaam']);
        $rol = trim($_POST['rol']);
        $herhaalWachtwoord = trim($_POST['herhaalWachtwoord']);

        if (empty($voornaam) || empty($achternaam) || empty($email) || empty($wachtwoord) || empty($telefoon) || empty($herhaalWachtwoord)) {
            $this->render('register', ['error' => 'Alle velden zijn verplicht.']);
            return;
        }

        $this->model = new RegisterModel();

        if ($this->model->userExists($email)) {
            $this->render('register', ['error' => 'Gebruiker bestaat al.']);
            return;
        }

        if ($wachtwoord !== $herhaalWachtwoord) {
            $this->render('register', ['error' => 'Wachtwoorden komen niet overeen.']);
            return;
        }

        $this->model->register($voornaam, $achternaam, $telefoon, $email, $wachtwoord, $gebruikersnaam, $rol);

        $verificationCode = $this->generateVerificationCode();
        if ($this->verifyEmail($email, $verificationCode)) {
            $this->render('login', ['succes' => 'Gebruiker is geregistreerd en een verificatiecode is verzonden.']);
        } else {
            $this->render('register', ['error' => 'Gebruiker is geregistreerd, maar e-mailverificatie is mislukt.']);
        }
    }

    //functie om 6 cijferige code te genereren 
    public function generateVerificationCode($length = 6)
    {
        $characters = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];

        }
        return $code;
    }

    //functie om een 6 cijferige code te sturen
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
}
