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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


        if (isset($_SESSION['verificationCode'])) {
            $this->render('register', ['step' => 'verify']); 
        } else {
            $this->render('register'); 
        }
    }
        
        public function register()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $voornaam = isset($_POST['voornaam']) ? trim($_POST['voornaam']) : null;
        $achternaam = isset($_POST['achternaam']) ? trim($_POST['achternaam']) : null;
        $telefoon = isset($_POST['telefoon']) ? trim($_POST['telefoon']) : null;
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $wachtwoord = isset($_POST['wachtwoord']) ? trim($_POST['wachtwoord']) : null;
        $gebruikersnaam = isset($_POST['gebruikersnaam']) ? trim($_POST['gebruikersnaam']) : null;
        $rol = isset($_POST['rol']) ? trim($_POST['rol']) : null;
        $is_geverifieerd = isset($_POST['is_geverifieerd']) ? trim($_POST['is_geverifieerd']) : '0';
        $herhaalWachtwoord = isset($_POST['herhaalWachtwoord']) ? trim($_POST['herhaalWachtwoord']) : null;

        if (empty($voornaam) || empty($achternaam) || empty($email) || empty($wachtwoord) || empty($telefoon) || empty($herhaalWachtwoord)) {
            $this->render('register', ['error' => 'Alle velden zijn verplicht.']);
            return;
        }

        if ($wachtwoord !== $herhaalWachtwoord) {
            $this->render('register', ['error' => 'Wachtwoorden komen niet overeen.']);
            return;
        }

        $this->model = new RegisterModel();
        if ($this->model->userExists($email)) {
            $this->render('register', ['error' => 'Er is al een gebruiker met dit e-mailadres.']);
            return;
        }

        $_SESSION['register_data'] = [
            'voornaam' => $voornaam,
            'achternaam' => $achternaam,
            'telefoon' => $telefoon,
            'email' => $email,
            'wachtwoord' => $wachtwoord,
            'gebruikersnaam' => $gebruikersnaam,
            'rol' => $rol,
            'is_geverifieerd' => $is_geverifieerd
        ];

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

            $mail->setFrom('gilde.easyevents@gmail.com', 'EasyEvents');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verificatiecode';
            $mail->Body = "
                            <html>
                                <head>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            background-color: #f4f4f4;
                                            padding: 20px;
                                        }
                                        .container {
                                            max-width: 500px;
                                            background-color: #fff;
                                            padding: 20px;
                                            border-radius: 10px;
                                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                            text-align: center;
                                        }
                                        .code {
                                            font-size: 24px;
                                            font-weight: bold;
                                            color: #4CAF50;
                                            padding: 10px;
                                            background-color: #e8f5e9;
                                            display: inline-block;
                                            border-radius: 5px;
                                            margin-top: 10px;
                                        }
                                        .footer {
                                            margin-top: 20px;
                                            font-size: 12px;
                                            color: #666;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class='container'>
                                        <h2>Verificatiecode</h2>
                                        <h4>Welkom bij EasyEvents! Hier kun je eenvoudig solliciteren voor allerlei soorten evenementen, van concerten en festivals tot workshops en conferenties.<h4>
                                        <p>Gebruik onderstaande code om uw e-mailadres te verifiëren:</p>
                                        <div class='code'>$verificationCode</div>
                                    </div>
                                </body>
                            </html>
                        ";


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
    if (session_status() == PHP_SESSION_NONE) 
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
                $registerData['rol'],
                $registerData['is_geverifieerd']
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
