<?php 
    require_once("Mailer_API.php");

    function getPostData($key) {
        return isset($_POST[$key]) ? strip_tags(htmlentities(htmlspecialchars($_POST[$key])))  : "";
    }

    if ($_SERVER['REQUEST_METHOD'] != 'POST')
        die(array(
            "title" => "Error",
            "msg" => "Wystąpił błąd podczas wysyłania wiadomości",
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
            "msg" => "Wystąpił błąd podczas wysyłania wiadomości",
            "code" => "400",
            "icon" => "error",
            "footer" => "Spróbuj ponownie"
        ));

    $title = getPostData("title");
    $email = getPostData("email");
    $message = getPostData("message");
    $name = getPostData("name");

    if (empty($title) || empty($email) || empty($message) || empty($name))
        die(array(
            "title" => "Error",
            "msg" => "Wystąpił błąd podczas wysyłania wiadomości",
            "code" => "400",
            "icon" => "error",
            "footer" => "Spróbuj ponownie"
        ));
    
    $mailer = new Mailer_API();
    $response = $mailer->sendContactMail($email, $name, $title, $message);
    echo json_encode($response);

    
?>