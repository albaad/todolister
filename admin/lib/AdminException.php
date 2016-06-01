<?php

class AdminException extends Exception {
  public function __construct($message=NULL, $code = 0) {
    parent::__construct($message, $code);
  }
}

class InvalidLoginException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Mot de passe erroné !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class InvalidUserException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Login erroné !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserLengthException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Veuillez choisir une adresse e-mail entre 4 et 50 caractères !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

/*class UnavailableUsernameException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Le pseudo n'est pas disponible.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}*/

class UnavailableEmailException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Un compte lié à cet e-mail existe déjà.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class PasswordsDontMatchException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Les mots de passe ne correspondent pas !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongPasswordLengthException extends AdminException {
  public function showMessage(){
    $_SESSION['error']  = "Veuillez saisir un mot de passe entre 4 et 15 caractères !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserIDException extends AdminException {
  public function showMessage(){
    $_SESSION['error'] = 'ID n\'existe pas !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserEmailException extends AdminException {
  public function showMessage(){
    $_SESSION['error'] = 'Il n\'existe aucun compte lié à cet e-mail.';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class UserNotLoggedInException extends AdminException {
  public function showMessage(){
    $_SESSION['error'] = 'Vous n\'êtes pas loggé !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:authentification.php');
  }
}

class InvalidAccountException extends AdminException {
  public function showMessage(){
    $_SESSION['error'] = "Votre compte n'a pas encore été activé.\nVeuillez vérifier votre boîte mail et confirmer votre inscription.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:authentification.php');
  }
}


?>
