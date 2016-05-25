<?php

class AdminException extends Exception {
  public function __construct($message=NULL, $code = 0) {
    parent::__construct($message, $code);
  }
}

class InvalidLoginException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Mot de passe erroné !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class InvalidUserException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Login erroné !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserLengthException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Veuillez choisir un pseudo entre 4 et 15 caractères !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class UnavailableUsernameException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Le pseudo n'est pas disponible.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class UnavailableEmailException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Un compte lié à cet e-mail existe déjà.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class PasswordsDontMatchException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Les mots de passe ne correspondent pas !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongPasswordLengthException extends AdminException {
  public function showMessage(){
    $_SESSION['message']  = "Veuillez saisir un mot de passe entre 4 et 15 caractères !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserIDException extends AdminException {
  public function showMessage(){
    $_SESSION['message'] = 'ID n\'existe pas !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserEmailException extends AdminException {
  public function showMessage(){
    $_SESSION['message'] = 'L\'email n\'existe pas !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class UserNotLoggedInException extends AdminException {
  public function showMessage(){
    $_SESSION['message'] = 'Vous n\'êtes pas loggé !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:/authentification.php');
  }
}



?>
