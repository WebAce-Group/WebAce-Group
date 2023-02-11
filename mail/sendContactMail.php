<?php 
    require_once("Mailer_API.php");

    function getPostData($key) {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key])  : "";
    }

    if ($_SERVER['REQUEST_METHOD'] != 'POST')
        die(array(
            "title" => "Error",
            "content" => "Wystąpił błąd podczas wysyłania wiadomości",
            "code" => "400",
            "icon" => "error",
            "footer" => "Spróbuj ponownie"
        ));
    $origins = array(
        "https://www.webace-group.dev",
        "http://localhost:5500/index.html"
    );
    if(!in_array($_SERVER['HTTP_ORIGIN'], $origins))
        die(array(
            "title" => "Error",
            "content" => "Wystąpił błąd podczas wysyłania wiadomości",
            "code" => "400",
            "icon" => "error",
            "footer" => "Spróbuj ponownie"
        ));
    
?>