<?php

class ListerException extends Exception {
  public function __construct($message=NULL, $code = 0) {
    parent::__construct($message, $code);
  }
}

class InvalidLoginException extends ListerException {
  public function showMessage(){
    $_SESSION['error']  = "Mot de passe erroné !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class InvalidUserException extends ListerException {
  public function showMessage(){
    $_SESSION['error']  = "Login erroné !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserLengthException extends ListerException {
  public function showMessage(){
    $_SESSION['error']  = "Veuillez choisir une adresse e-mail entre 4 et 50 caractères !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class UnavailableEmailException extends ListerException {
  public function showMessage(){
    $_SESSION['error']  = "Un compte lié à cet e-mail existe déjà.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class PasswordsDontMatchException extends ListerException {
  public function showMessage(){
    $_SESSION['error']  = "Les mots de passe ne correspondent pas !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongPasswordLengthException extends ListerException {
  public function showMessage(){
    $_SESSION['error']  = "Veuillez saisir un mot de passe entre 4 et 15 caractères !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserIDException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = 'ID n\'existe pas !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class WrongUserEmailException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = 'Il n\'existe aucun compte lié à cet e-mail.';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
  }
}

class UserNotLoggedInException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = 'Vous n\'êtes pas loggé !';
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:authentification.php');
  }
}

class InvalidAccountException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = "Votre compte n'a pas encore été activé.\nVeuillez vérifier votre boîte mail et confirmer votre inscription.";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:authentification.php');
  }
}

class NotFilledUpFormException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = "Vous devez compléter tous les champs du formulaire !";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:authentification.php');
  }
}

class NotFilledUpIDException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = "Veuillez renseigner l'ID";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    }
     header('Location:delete.php');
  }
}

class InvalidEmailFormatException extends ListerException {
  public function showMessage(){
    $_SESSION['error'] = "Adresse e-mail incorrecte";
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    } else {
     header('Location:inscription.php');
   }
  }
}
?>
