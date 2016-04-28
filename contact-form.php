<?php
  session_start();
// Vérifie que les champs ne sont pas vides
	if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["subject"]) || empty($_POST["msg"])) {
		$_SESSION['error'] = "Vous devez compléter tous les champs du formulaire !";
		header('Location:contact.php');
	}
	else {
		// Vérifie format adresse email
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "Format email invalide";
		  $_SESSION['error'] = $emailErr;
			header('Location:contact.php');
		}

    /* Envoi e-mail */
    $subjectPrefix = '[To Do Lister]';
    $emailTo = '<test.dev.at@gmail.com>';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name    = stripslashes(trim($_POST['name']));
        $email   = stripslashes(trim($_POST['email']));
        $subject = stripslashes(trim($_POST['subject']));
        $message = stripslashes(trim($_POST['msg']));
        $pattern = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
        if (preg_match($pattern, $name) || preg_match($pattern, $email) || preg_match($pattern, $subject)) {
            die("Header injection detected");
        }
        $emailIsValid = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($name && $email && $emailIsValid && $subject && $message){
            $subject = "$subjectPrefix $subject";
            $body = "Nom : $name <br /> Email : $email <br /> Message : $message";
            $headers  = "MIME-Version: 1.1" . PHP_EOL;
            $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
            $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
            $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
            $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
            $headers .= "From: " . "=?UTF-8?B?".base64_encode($name)."?=" . "<$email>" . PHP_EOL;
            $headers .= "Return-Path: $emailTo" . PHP_EOL;
            $headers .= "Reply-To: $email" . PHP_EOL;
            $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
            $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;
            mail($emailTo, "=?utf-8?B?".base64_encode($subject)."?=", $body, $headers);
            $emailSent = true;
            $_SESSION['emailSent'] = $emailSent;
            header('Location:contact.php');
        } else {
            $hasError = true;
        }
      }
    }
?>
