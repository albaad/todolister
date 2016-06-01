<?php
session_start();
include_once 'admin/lib/Connection.php';
include_once 'admin/lib/AdminException.php';

class UserManager {

  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function login($email, $pw) {
    try {
      if (is_null($email) || strlen($email) < 3 || strlen($email) > 20) {
        throw new WrongUserLengthException();
      }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException();
      }
      $pw = sha1($pw);
      // Verify if user account has been activated
      if (!($this->activeAccount($email))) {
        throw new InvalidAccountException();
      }
      // Verify login credentials
      if ($this->find($email) && $this->verifyLogin($email, $pw)) {
          $_SESSION['email'] = $email;
          if($_SESSION['email'] == 'admin') {
            header("location: admin/admin.php"); }
          else {
            header("Location:app/index.php");
          }
      }
      else { throw new InvalidUserException(); }
    }
    catch(WrongUserLengthException $e) { $e->showMessage(); }
    catch(WrongPasswordLengthException $e) { $e->showMessage(); }
    catch(InvalidAccountException $e) { $e->showMessage(); }
    catch(InvalidUserException $e) { $e->showMessage(); }
  }

  public function register($email, $pw, $pw2) {
    try {
      // All possible errors
      if ($this->find($email)) { throw new UnavailableEmailException(); }
      if (is_null($email) || strlen($email) < 3 || strlen($email) > 20) {
        throw new WrongUserLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      // If no errors, proceed to insert user into DB
      $bdd = $this->db;
      $req = $bdd->prepare("
        INSERT INTO users(email, pw)
        VALUES(:email, :pw)
      ");
      $req->execute([
        'email' => $email,
        'pw' => sha1($pw)
      ]);
      /* Add row to confirm awaiting account validation */
      // Get assigned user id
      $bdd = $this->db;
      $req = $bdd->prepare("
        SELECT id FROM users
        WHERE email=:email
      ");
      $req->execute([
        'email' => $email
      ]);
      $donnees = $req->fetch();
      $user_id = $donnees['id'];
      // Create a random key
      $key = $pw . $email . date('mY');
      $key = md5($key);
      // Add confirm row
      $confirm = $this->db->query("
        INSERT INTO `confirm`
        VALUES(NULL,'$user_id','$key','$email')
      ");
      if($confirm) {
        $_SESSION['signup'] = $email;
        $_SESSION['key'] = $key;
        header('location:inscription.php');
      } else {
          unset($_SESSION['signup']);
      }
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableEmailException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
  }

  public function forgottenPassword($email) {
    try {
      // Check if an account exists for the given email
      if (!($this->find($email))) { throw new WrongUserEmailException(); }
      // Get hashed password and user id
      $bdd = $this->db;
      $req = $bdd->prepare("
        SELECT * FROM users
        WHERE email=:email
      ");
      $req->execute([
        'email' => $email
      ]);
      $data = $req->fetch();
      $pw = $data['password'];
      $user_id = $data['id'];
      $_SESSION['confirmation'] = $user_id;
      // Create a random key
      $key = $pw . $email . date('mY');
      $key = md5($key);
      // Add confirm row
      $confirm = $this->db->query("
        INSERT INTO `confirm`
        VALUES(NULL,'$user_id','$key','$email')
      ");

      if($confirm) {
        $_SESSION['forgot'] = 1;
        $_SESSION['key'] = $key;
        $_SESSION['confirmation'] = "user-Veuillez changer votre mot de passe via le lien que vous a été envoyé.";
        header('location:forgotpassword.php');
      } else {
        $_SESSION['error'] = "user-Une erreur s'est produite";
        header('location:forgotpassword.php');
      }
    }
    // Exceptions CATCH block
    catch (WrongUserEmailException $e) { $e->showMessage(); }
  }

  public function verifyLogin($email, $pw) {
    $bdd = $this->db;
    $req = $bdd->prepare("
      SELECT COUNT(email) FROM users
      WHERE email=:email AND pw=:pw
    ");
    $req->execute([
      'email' => $email,
      'pw' => $pw
    ]);
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];
    // IF res = $email AND $pw, 1 result
     if($count == 1) {
       return true;
     } else {
       return false;
     }
  }

  public function activeAccount($email) {
    $bdd = $this->db;
    $req = $bdd->prepare("
      SELECT COUNT(*) FROM users
      WHERE email=:email AND active = :active
    "); // 1
    $req->execute([
      'email' => $email,
      'active' => 1
    ]);
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
    $req = $bdd->prepare("
      SELECT COUNT(email) FROM users
      WHERE email=:email
    ");
    $req->execute([
      'email' => $email
    ]);
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
      $req = $bdd->prepare("
        SELECT email FROM users
        WHERE id=:id
      ");
      $req->execute([
        'id' => $id
      ]);
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

  public function getIdByEmail($email) {
    try {
      $bdd = $this->db;
      $req = $bdd->prepare("
        SELECT id FROM users
        WHERE email=:email
      ");
      $req->execute([
        'email' => $email
      ]);
      $donnees = $req->fetch();
      $count = $donnees['id'];
      // IF res = $email, 1 result
       if(!empty($count)) {
         return $donnees['id'];
       } else {
         throw new WrongUserEmailException();
       }
     }
     catch (WrongUserEmailException $e) { $e->showMessage(); }
  }

  public function update($newEmail, $pw, $pw2) {
    try {
      // Check if there are any input errors
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }

      if (isset($_SESSION['email'])) {
        if (isset($_SESSION['email']))
          $email = $_SESSION['email'];
        // Get user id, corresponding to current email
        $id = $this->getIdByEmail($email);
        // If email has changed: Check if new email is available
        if ($email != $newEmail) {
          if (is_null($email) || strlen($email) < 3 || strlen($email) > 20) {
            throw new WrongUserLengthException(); }
          if($this->find($newEmail)) {
            throw new UnavailableEmailException();
          }
        }
        // Update table
        $bdd = $this->db;
        $req = $bdd->prepare('
          UPDATE users SET pw = :pw, email = :email
          WHERE id = :id
        ');
        $req->execute(array(
          'email' => $newEmail,
          'pw' => sha1($pw),
          'id' =>$id
        ));
        $_SESSION['confirmation'] = "Paramètres modifiés.";
        $_SESSION['email'] = $newEmail;
        header($_SESSION['location']);
      } else {
        throw new UserNotLoggedInException();
      }
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableEmailException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
    catch (UserNotLoggedInException $e) { $e->showMessage(); }
  }

  public function resetPassword($email, $pw, $pw2, $key) {
    try {
      // Check if there are any input errors
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }

      // Get user id, corresponding to current email
      $id = $this->getIdByEmail($email);
      // Update users table
      $bdd = $this->db;
      $req = $bdd->prepare('
        UPDATE users SET pw = :pw, email = :email
        WHERE id = :id
      ');
      $req->execute(array(
        'email' => $email,
        'pw' => sha1($pw),
        'id' =>$id
      ));
      // Delete the confirm row
      $req = $bdd->query("
        SELECT `id` FROM `confirm`
        WHERE `user_id` = '$id' AND `key` = '$key'
      ");
      $check_key = $req->fetch();
      $confirm_id = $check_key['id'];

      $delete = $bdd->query("DELETE FROM `confirm` WHERE `id` = '$confirm_id'");

      $_SESSION['confirmation'] = "Paramètres modifiés.";
      header($_SESSION['location']);
    }
    // Exceptions CATCH blocks
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
  }


  public function delete($email) {
    if ($this->find($email)){
      $bdd = $this->db;
      $req = $this->db->prepare('DELETE FROM users WHERE email = :email');
      $req->execute(array(
        'email' => $email
      ));
      $_SESSION['error'] = "Utilisateur supprimé.";
      unset($_SESSION['email']);
      // Redirect
      header('Location: goodbye.php');
    }
    else { throw new WrongUserEmailException(); }
  }

  public function is_logged_in() {
    // Verifies user is logged in
    if(!isset($_SESSION['email'])) {
      if(empty($_POST['email']) || empty($_POST['password'])) {
        // User not logged in
        return false;
      }
    }
    return true;
  }

}

?>
