<?php
ob_start();
session_start();

require __DIR__."/vendor/autoload.php";

if(empty($_SESSION["user"])){
    echo "<h1>Guest user</h1>";
    
    /**
     * AUTH GOOGLE
     */

     $google = new \League\OAuth2\Client\Provider\Google(GOOGLE);
     $error = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING );
     $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING );

     $authUrl = $google->getAuthorizationUrl();

    if($error){
        echo "<h3>Voce precisa autorizar para continuar!</h3>";
    }
    
    if($code) {
        $token = $google->getAccessToken('authorization_code', [
            "code" => $code
        ]);
        
        $_SESSION["user"] = serialize($google->getResourceOwner($token));

        header("Location: ".GOOGLE["redirectUri"]);
        exit;
    }

    echo "<a title='Logar como Google' href='{$authUrl}'>Google Login</a>";

    

  

} else {
    echo "<h1>user</h1>";
   
    $user = unserialize($_SESSION["user"]);

    echo "<img src='{$user->getAvatar()}' alt='' title=''><h1>Bem vindo (a) {$user->getFirstName()} </h1>";

    echo "</br>";
    echo "<a title='Sair' href='?off=true'>Sair</a>";
        $off = filter_input(INPUT_GET, "off", FILTER_VALIDATE_BOOLEAN);
        if($off){
            unset($_SESSION["user"]);
            header("Refresh: 0");
        }
}

ob_end_flush();