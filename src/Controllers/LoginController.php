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

}