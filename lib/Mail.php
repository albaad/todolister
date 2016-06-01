<?php

class Mail {

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
  public function setMessage($subtitle, $message, $text, $link, $linkText){
    //$this->message = $message;
    $this->message = "<body>
            <div class='container' style='min-width: 650; max-width: 700; padding: 2% 20%; text-align: center; font-family: Arial,helvetica,sans-serif; font-size: 15px;'>
              <div class='logo' style='display: block; margin-bottom: 10px;'>
                <a href='http://localhost/proyectos/nfa021-tp/index.php' style='text-decoration: none;'>
                  <img src='http://i1228.photobucket.com/albums/ee460/reinovacio/ToDoLister/logo-sm_zpshfz57b6b.png' border='0'/>
                </a>
              </div>
              <div class='space-bar' style='display: block; min-width: 100%; height: 10px; background-color: #8d949a;'></div>
              <span class='sub-title' style='display: block; margin: 12px 0; color: #8d949a; font-size: 20px;'>$subtitle</span>
                <hr style='display: block; height: 2px; border: 0; border-top: 2px solid #EAEAEA; margin: 1em 0; padding: 0;'>
              <div class='content' style='text-align: left;'>
                <p style='margin-bottom: 12px;'>$message</p>
                <p style='margin-bottom: 12px;'>$text</p>
                <p style='margin-bottom: 12px; text-align: center;'>
                  <a href='$link' style='text-decoration: none; background-color: #2ec966; color: #f3f3f3; display: inline-block; text-align: center; height: 25px; width: auto; padding: 10px 20px 5px 20px;'>
                  $linkText</a>
                </p>
                <p style='text-align: left; margin: 20px 0 30px 0;'>
                  L'équipe To Do Lister
                </p>
              </div>
              <div id='footer' style='font-size: 9px;width: 100%;height: 40px;margin: 0 auto;text-align: center;padding: 20px 10px 0 10px;font-family: Arial;background-color: #EAEAEA;'>
                 Tous droits réservés @ To Do Lister 2016
              </div>
            </div>
        <style media='screen'>
          .container { max-width: 60%; padding: 10% 20%; text-align: center; font-family: Arial,helvetica,sans-serif; font-size: 15px; }
          .logo { display: block; margin-bottom: 10px; }
          .logo a { text-decoration: none; }
          .logo i, .logo span { color: #2ec866; }
          .logo i { font-size: 36px; }
          .logo span { font-family: 'Sofia', cursive; font-size: 34px; }
          .space-bar { display: block; min-width: 100%; height: 10px; background-color: #8d949a;}
          .sub-title { display: block; margin: 12px 0; color: #8d949a; font-size: 20px; }
          hr { display: block; height: 2px; border: 0; border-top: 2px solid #EAEAEA; margin: 1em 0; padding: 0;}
          .content { text-align: left;}
          .content p { margin-bottom: 12px; }
          #button { text-align: center;}
          #button a { text-decoration: none; background-color: #2ec966; color: #f3f3f3; display: inline-block; text-align: center; height: 25px; width: auto; padding: 10px 20px 5px 20px; }
          #button a:hover { background-color: #16aa56;}
          #signature { text-align: left; margin: 20px 0 30px 0;}
        </style>
     </body>";
  }

  /* Generates email signature */
  public function createSignature($bool) {
    if ($bool)
      $this->signature = "<br/> $this->name <br /> $this->email <br />";
    else
      $this->signature = "";
  }

  /* Sends e-mail */
  public function sendMail($subjectPrefix, $emailTo, $confirmationMsg, $errorMsg) {
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
              $this->displayError($confirmation);
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
  public function displayError($message) {
    $_SESSION['error'] = $message;
    header($_SESSION['location']);
  }

}

?>
