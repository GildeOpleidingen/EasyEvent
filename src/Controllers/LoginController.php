<?php

namespace App\Controllers;

use App\Controller;
use App\Models\LoginModel;
use App\Models\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController extends Controller
{
    protected $model;

    public function __construct()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new LoginModel();
    }

    public function index()
    {
        if (isset($_SESSION['GebruikerEmail'])) {
            header('Location: /events');
            exit();
        }
        $this->render('login');
    }
    public function login()
    {
        $gebruikersnaam = trim($_POST['Gebruikersnaam'] ?? '');
        $wachtwoord = trim($_POST['wachtwoord'] ?? '');
        //$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

        if (empty($gebruikersnaam) || empty($wachtwoord)) {
            $this->render('login', ['error' => 'Vul alle velden in.']);
            return;
        }

        // $recaptchaSecret = '6LdGioIqAAAAADKUk1OCnriLFES0x2-r5RmU29Gx';
        // if (!$this->verifyRecaptcha($recaptchaSecret, $recaptchaResponse)) {
        //     $this->render('login', ['error' => 'reCAPTCHA verificatie is mislukt.']);
        //     return;
        // }

        $result = $this->model->login($gebruikersnaam, $wachtwoord);

        if ($result === 'events') {
            $gebruikerData = $this->model->getUserByEmail($gebruikersnaam);
            if ($gebruikerData) {

                $gebruiker = new UserModel();

                $gebruiker->setUserData($gebruikerData);
                $_SESSION['gebruiker'] = serialize($gebruiker);

                /* test voor object usermodel
                echo '<pre>';
                echo 'Gebruiker ingelogd!<br>';
                echo ' UserModel Object:<br>';
                echo $_SESSION['gebruiker'];
                echo '</pre>';
            

                exit();
                */
            
                header('Location: /events');
                exit();
            }
        } else {
            $this->render('login', ['error' => 'Inlog gegevens zijn incorrect, probeer het opnieuw.']);
        }
      
    }

    private function verifyRecaptcha($secret, $response)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $verification = json_decode($result, true);

        return isset($verification['success']) && $verification['success'];
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header('Location: /login');
        exit();
    }

    public function forgotPasswordForm()
    {
        $this->render('forgot-password'); 
    }

    public function sendResetEmail()
    {
        $email = trim($_POST['email'] ?? '');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

        if (empty($email)) {
            $this->render('forgot-password', ['error' => 'Vul een e-mailadres in.']);
            return;
        }

        // ---------------- Rate Limiting ----------------
        require_once __DIR__ . '/../../functions/rate_limiting.php';

        // Use PDO from your model (assuming $this->model->db exists)
        try {
            checkRateLimit($this->model->getDb(), $ip, $email, 5, 300, "Te veel pogingen. Probeer het over 5 minuten opnieuw.");
        } catch (\Exception $e) {
            $this->render('forgot-password', ['error' => $e->getMessage()]);
            return;
        }

        // ---------------- Forgot Password Logic ----------------
        if ($this->model->userExists($email)) {
            $resetCode = $this->generateResetCode();
            $_SESSION['reset_code'] = $resetCode;
            $_SESSION['reset_email'] = $email;

            if ($this->sendResetEmailToUser($email, $resetCode)) {
                $this->render('forgot-password', ['success' => 'Een resetcode is naar je e-mailadres gestuurd.']);
            } else {
                $this->render('forgot-password', ['error' => 'Er is een probleem met het versturen van de e-mail.']);
            }
        } else {
            $this->render('forgot-password', ['error' => 'Dit e-mailadres is niet bij ons bekend.']);
        }
    }

    public function verifyResetCode()
    {

        $enteredCode = trim($_POST['reset_code'] ?? '');
        $savedCode   = $_SESSION['reset_code'] ?? '';
        $email       = $_SESSION['reset_email'] ?? '';

        if (empty($enteredCode)) {
            $this->render('forgot-password', ['error' => 'Vul een code in.']);
            return;
        }


        if ($enteredCode === $savedCode) {
            $this->render('reset-password-form', ['email' => $email]);
        } else {

            $this->render('forgot-password', ['error' => 'Ongeldige code.']);
        }
    }

public function resetPassword()
{
    $email = $_SESSION['reset_email'] ?? null;
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if (empty($email)) {
        $this->render('forgot-password', ['error' => 'Sessie verlopen. Vraag een nieuwe resetcode aan.']);
        return;
    }

    if (empty($password) || empty($confirmPassword)) {
        $this->render('reset-password-form', ['error' => 'Vul alle velden in.', 'email' => $email]);
        return;
    }

    if ($password !== $confirmPassword) {
        $this->render('reset-password-form', ['error' => 'De wachtwoorden komen niet overeen.', 'email' => $email]);
        return;
    }

    if (strlen($password) < 8) {
        $this->render('reset-password-form', ['error' => 'Het wachtwoord moet minimaal 8 tekens bevatten.', 'email' => $email]);
        return;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $userModel = new \App\Models\UserModel();  // <-- use UserModel
    if ($userModel->updatePassword($email, $hashedPassword)) {
        unset($_SESSION['reset_code'], $_SESSION['reset_email']);
        $this->render('login', ['success' => 'Je wachtwoord is succesvol gewijzigd.']);
    } else {
        $this->render('reset-password-form', ['error' => 'Er ging iets mis bij het wijzigen van je wachtwoord.', 'email' => $email]);
    }
}

    private function generateResetCode($length = 6)
    {
        return strtoupper(substr(md5(mt_rand()), 0, $length));
    }

    private function sendResetEmailToUser($email, $resetCode)
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
            $mail->Subject = 'Wachtwoord resetcode';
            $mail->Body = "Je resetcode is: <strong>$resetCode</strong>. Voer deze code in om je wachtwoord opnieuw in te stellen.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
