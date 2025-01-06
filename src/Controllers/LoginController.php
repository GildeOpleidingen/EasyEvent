<?php

namespace App\Controllers;

use App\Controller;

class LoginController extends Controller
{
    public function index()
    {
        if(isset($_SESSION['Gebruikersnaam'])){
            header('Location: HTTP://' . $_SERVER["HTTP_HOST"] . "/events");
        }
        $this->render('login');
    }

    public function __construct()
    {
        $this->model = new \App\Models\LoginModel();
    }

    public function login(){

        $recaptchaSecret = '6LdGioIqAAAAADKUk1OCnriLFES0x2-r5RmU29Gx'; 
        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
        $recaptchaVerification = $this->verifyRecaptcha($recaptchaSecret, $recaptchaResponse);

        if (!$recaptchaVerification) {
            $this->render('login', ['error' => 'reCAPTCHA verificatie is mislukt.']);
            return;
        }

        $reslt = $this->model->login($_POST["Gebruikersnaam"], $_POST["wachtwoord"]); 

        if($reslt == "events"){
            header('Location: HTTP://' . $_SERVER["HTTP_HOST"] . "/events");
        } else {
            $this->render('login', ['error' => 'Gebruikersnaam of wachtwoord komen niet overeen.']);
            return;
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

    public function logout(){
        session_destroy();

        header('Location: HTTP://' . $_SERVER["HTTP_HOST"] . "/login");
    }

    public function forgotPasswordForm()
{
    $this->render('forgot-password'); // Render the forgot password view
}

public function sendResetEmail()
{
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $this->render('forgot-password', ['error' => 'Vul een e-mailadres in.']);
        return;
    }

    $this->model = new \App\Models\LoginModel();

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
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
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
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}


}
