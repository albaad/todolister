<?php

class ContactFormulaire {

  private $name;
  private $email;
  private $subject;
  private $message;
  private $signature;

  /* Retrieve all form fields */
  public function retrieveForm() {
    $this->name = stripslashes(trim($_POST['name']));
    $this->email = stripslashes(trim($_POST['email']));
    $this->subject = stripslashes(trim($_POST['subject']));
    $this->message = stripslashes(trim($_POST['msg']));
  }

  /* Verifies fields are valid */
  public function testForm() {
    // Verifies fiels are filled
    if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["msg"])
       && (!empty($_POST["name"]) || !empty($_POST["email"]) || !empty($_POST["subject"]) || !empty($_POST["msg"]))) {
       // Verifies email address format
       if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
         $error = "Format email invalide";
         $this->displayErreur($error);
         return false;
       } else {
         return true;
       }
    }
    else {
      $error = "Vous devez compléter tous les champs du formulaire !";
      $this->displayErreur($error);
      return false;
    }
  }

  /* Setters */
  public function setName($name){
    $this->name = $name;
  }
  public function setEmail($email){
    $this->email = $email;
  }
  public function setSubject($subject){
    $this->subject = $subject;
  }
  public function setMessage($message){
    $this->message = $message;
  }

  /* Generates email signature */
  public function createSignature() {
    $this->signature = "<br/> $this->name <br /> $this->email <br />";
  }

  /* Sends e-mail */
  public function sendMail($subjectPrefix, $emailTo, $confirmationMsg, $errorMsg) {
    //$subjectPrefix = '[To Do Lister]';
    //$emailTo = '<test.dev.at@gmail.com>';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pattern = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
        if (preg_match($pattern, $this->name) || preg_match($pattern, $this->email) || preg_match($pattern, $this->subject)) {
            die("Header injection detected");
        }
        $emailIsValid = filter_var($this->email, FILTER_VALIDATE_EMAIL);
        if($this->name && $this->email && $emailIsValid && $this->subject && $this->message){
            $this->subject = "$subjectPrefix $this->subject";
            $body = "$this->message <br/> $this->signature";
            $headers  = "MIME-Version: 1.1" . PHP_EOL;
            $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
            $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
            $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
            $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
            $headers .= "From: " . "=?UTF-8?B?".base64_encode($this->name)."?=" . "<$this->email>" . PHP_EOL;
            $headers .= "Return-Path: $emailTo" . PHP_EOL;
            $headers .= "Reply-To: $this->email" . PHP_EOL;
            $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
            $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;

            $success = mail($emailTo, "=?utf-8?B?".base64_encode($this->subject)."?=", $body, $headers);
            if($success) {
              $confirmation = $confirmationMsg;
              $this->displayMessage($confirmation);
            }
            else {
              $confirmation = $errorMsg;
              $this->displayErreur($confirmation);
              $hasError = true;
            }

        } else {
            $hasError = true;
        }
      }
  }

  /* Displays confirmation and information messages */
  public function displayMessage($message) {
    $_SESSION['confirmation'] = $message;
    header($_SESSION['location']);
  }

  /* Displays error messages */
  public function displayErreur($message) {
    $_SESSION['error'] = $message;
    header('Location:contact.php');
  }

}

?>
