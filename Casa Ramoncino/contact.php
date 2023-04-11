<?php

// Obtener los valores de entrada y filtrarlos
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

// Verificar si se está utilizando el método HTTP POST
$post = ($_SERVER['REQUEST_METHOD'] == 'POST');

// Comprobar si hay errores de entrada
$errors = array();
if (!$name) $errors[] = 'Please enter your name.';
if (!$email) $errors[] = 'Please enter a valid email address.';
if (!$comment) $errors[] = 'Please enter your message.';

// Si no hay errores, enviar el correo electrónico
if (empty($errors)) {
    require_once 'vendor/autoload.php'; // Cargar la clase PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer(); // Instanciar la clase

    // Configurar los detalles del correo electrónico
    $mail->setFrom($email, $name);
    $mail->addAddress('samson3d@gmail.com');
    $mail->Subject = 'Message from ' . $name;
    $mail->Body = 'Name: ' . $name . '<br/><br/>
                   Email: ' . $email . '<br/><br/>        
                   Message: ' . nl2br($comment) . '<br/>';

    // Enviar el correo electrónico y verificar si ha tenido éxito
    if ($mail->send()) {
        $message = 'Thank you! Your message has been sent.';
    } else {
        $message = 'Sorry, unexpected error. Please try again later.';
    }

    // Si se está utilizando el método HTTP POST, mostrar el mensaje de éxito o error
    if ($post) {
        echo $message;
    }
} else {
    // Si hay errores de entrada, mostrarlos y un enlace para volver atrás
    foreach ($errors as $error) {
        echo $error . '<br/>';
    }
    echo '<a href="index.html">Back</a>';
}
