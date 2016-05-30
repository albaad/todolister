<?php
session_start();
include_once 'Connection.php';

class AdminManager {

  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function addUser($pseudo, $pw, $pw2) {
    try {
      // All possible errors
      if ($this->find($pseudo)) { throw new UnavailableUsernameException(); }
      if (is_null($pseudo) || strlen($pseudo) < 3 || strlen($pseudo) > 16) {
        throw new WrongUserLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      // If no errors, proceed to insert user into DB
      $bdd = $this->db;
      $req = $bdd->prepare('INSERT INTO users(email, pw) VALUES(:email, :pw)');
      $req->execute(array(
        'email' => $pseudo,
        'pw' => sha1($pw)
      ));
      $_SESSION['email'] = $pseudo;
      header("Location:admin.php");
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableUsernameException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
  }

  public function getAll() {
    $bdd = $this->db;
    $req = $bdd->query("SELECT id, email, pw FROM users ORDER BY id ASC");
    return $req;
  }

  public function verifyLogin($pseudo, $pw) {
    $bdd = $this->db;
    $req = $bdd->query("SELECT COUNT(email) FROM users WHERE email='$pseudo' AND pw='$pw'");
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];
    // IF res = $email AND $pw, 1 result
     if($count == 1) { return true; }
     else { return false; }
  }

  public function find($pseudo) {
    $bdd = $this->db;
    $req = $bdd->query("SELECT COUNT(email) FROM users WHERE email='$pseudo'");
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];
    // IF res = $email, 1 result
     if($count == 1) { return true; }
     else { return false; }
  }

  public function getUserById($id) {
    try {
      $bdd = $this->db;
      $req = $bdd->query("SELECT email FROM users WHERE id='$id'");
      $donnees = $req->fetch();
      $count = $donnees['email'];
      // IF res = $email, 1 result
       if(!empty($count)) {
         $_SESSION['email'] = $donnees['email'];
         return $donnees['email'];
       } else { throw new WrongUserIDException(); }
     }
     catch (WrongUserIDException $e) { $e->showMessage(); }
  }

  public function update($id, $email, $pw) {
    try {
      // Verify new email and password length
      if (is_null($email) || strlen($email) < 3 || strlen($email) > 20) {
        throw new WrongUserLengthException(); }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException();
      }
      $id = (int)$id;
      if ($this->getUserById($id) != ''){
        // Verify the new email does not already exist in the DB
        $oldEmail = $this->getUserById($id);
        if ($oldEmail != $email) {
          if ($this->find($pseudo)) { throw new UnavailableUsernameException(); }
        }
        $bdd = $this->db;
        $req = $bdd->prepare('
          UPDATE users SET email = :email, pw = :pw
          WHERE id = :id
        ');
        $req->execute(array(
          'email' => $email,
          'pw' => sha1($pw),
          'id' => $id
        ));
        $_SESSION['message'] = "Utilisateur modifié.";
        header("Location:edit.php");
      }
      else { throw new WrongUserIDException(); }
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableUsernameException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
    catch (WrongUserIDException $e) { $e->showMessage(); }
  }

  public function delete($id) {
    try {
      $oldPseudo = $this->getUserById($id);
      if ($this->find($oldPseudo)){
        $bdd = $this->db;
        $this->db->exec('DELETE FROM users WHERE id = '.(int) $id);
        $_SESSION['message'] = "Utilisateur supprimé.";
        // Redirect
        if(isset($_SESSION['location'])) {
          header($_SESSION['location']);
        }
      }
      else { throw new WrongUserIDException(); }
    }
    catch (WrongUserIDException $e) { $e->showMessage(); }
  }

}

?>
