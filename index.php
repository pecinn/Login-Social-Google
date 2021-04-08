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
     $error = filter_input(INPUT_GET, 'error', )

     if(!isset($_GET['code'])){
        $token = $google->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        $_SESSION["userLogin"] = $google->getResourceOwner($token);
        header("Location: ". GOOGLE["redirectUri"]);
        die;
    }

      if(!isset($_GET['error'])){
        echo "<h3>Voce precisa autorizar para continuar!</h3>";
    }

} else {
    echo "<h1>user</h1>";
    var_dump($_SESSION["user"]);
}

ob_end_flush();