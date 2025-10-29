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
        if (isset($_SESSION['Gebruikersnaam'])) {
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
