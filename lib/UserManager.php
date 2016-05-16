<?php
session_start();
include_once 'admin/lib/ConnectionSingleton.php';
include_once 'admin/lib/AdminException.php';

class UserManager {

  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function login($email, $pw) {

    try {

      if (is_null($email) || strlen($email) < 3 || strlen($email) > 16) {
        throw new WrongUserLengthException();
      }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException();
      }
      $pw = sha1($pw);

      if ($this->find($email) && $this->verifyLogin($email, $pw)) {
          $_SESSION['email'] = $email;
          if($_SESSION['email'] == 'admin') {
            header("location: admin/admin.php"); }
          else {
            header("Location:accueil.php"); }
      }
      else { throw new InvalidUserException(); }

    }
    catch(WrongUserLengthException $e) { $e->showMessage(); }
    catch(WrongPasswordLengthException $e) { $e->showMessage(); }
    catch(InvalidUserException $e) { $e->showMessage(); }
  }

  public function register($email, $pw, $pw2) {
    try {
      // All possible errors
      if ($this->find($email)) { throw new UnavailableEmailException(); }
      if (is_null($email) || strlen($email) < 3 || strlen($email) > 16) {
        throw new WrongUserLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      // If no errors, proceed to insert user into DB
      $bdd = $this->db;
      $req = $bdd->prepare('INSERT INTO membres(email, pw) VALUES(:email, :pw)');
      $req->execute(array(
        'email' => $email,
        'pw' => sha1($pw)
      ));
      $_SESSION['email'] = $email;
      if($_SESSION['email'] == 'admin') {
        header("location: admin/admin.php");
      }
      header('location:accueil.php');
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableEmailException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
  }

  public function verifyLogin($email, $pw) {
    $bdd = $this->db;
    $req = $bdd->query("SELECT COUNT(email) FROM membres WHERE email='$email' AND pw='$pw'");
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];
    // IF res = $email AND $pw, 1 result
     if($count == 1) {
       return true;
     } else {
       return false;
     }
  }

  public function find($email) {
    $bdd = $this->db;
    $req = $bdd->query("SELECT COUNT(email) FROM membres WHERE email='$email'");
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];
    // IF res = $email, 1 result
     if($count == 1) {
       return true;
     } else {
       return false;
     }
  }

  public function getUserById($id) {
    try {
      $bdd = $this->db;
      $req = $bdd->query("SELECT email FROM membres WHERE id='$id'");
      $donnees = $req->fetch();
      $count = $donnees['email'];
      // IF res = $email, 1 result
       if(!empty($count)) {
         $_SESSION['email'] = $donnees['email'];
         return $donnees['email'];
       } else {
         throw new WrongUserIDException();
       }
     }
     catch (WrongUserIDException $e) { $e->showMessage(); }
  }

  public function update($email, $pw, $pw2) {
    try {
      // All possible errors
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }

      if ($this->find($email)){
        $bdd = $this->db;
        $req = $bdd->prepare('UPDATE membres SET pw = :pw WHERE email = :email');
        $req->execute(array(
          'email' => $email,
          'pw' => sha1($pw)
        ));
        $_SESSION['message'] = "Utilisateur modifié.";
        header($_SESSION['location']);
      }
      else {
        throw new WrongUserIDException();
      }
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableUsernameException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
    catch (WrongUserIDException $e) { $e->showMessage(); }
  }

  /*public function delete($id) {
    try {
      $oldPseudo = $this->getUserById($id);
      if ($this->chercher($oldPseudo)){
        $bdd = $this->db;
        $this->db->exec('DELETE FROM utilisateurs WHERE id = '.(int) $id);
        $_SESSION['message'] = "Utilisateur supprimé.";

        // Redirect
        header("Location:delete.php");
      }
      else {
        throw new WrongUserIDException();
      }
    }
    catch (WrongUserIDException $e) { $e->showMessage(); }
  }*/

  public function is_logged_in() {
    // Verifies user is logged in
    if(empty($_SESSION['email'])) {
      if(empty($_POST['email']) || empty($_POST['password'])) {
        // User not logged in
        return false;
      } else { // User logged in
      // Session variables for email
        $_SESSION['email'] = $_POST['email'];
      }
    }
    return true;
  }

}

?>