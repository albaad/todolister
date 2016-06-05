<?php
  session_start();

  include_once '../lib/Connection.class.php';
  include_once '../lib/ListerException.class.php';


class AdminManager {

  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function addUser($email, $pw, $pw2) {
    try {
      // All possible errors
      if (is_null($email) || is_null($pw) || is_null($pw2)) {
        throw new NotFilledUpFormException(); }
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          throw new InvalidEmailFormatException();  }
      if ($this->find($email)) { throw new UnavailableEmailException(); }
      if (is_null($email) || strlen($email) < 3 || strlen($email) > 50) {
        throw new WrongUserLengthException(); }
      if ($pw != $pw2) { throw new PasswordsDontMatchException(); }
      if (is_null($pw) || strlen($pw) < 3 || strlen($pw) > 16) {
        throw new WrongPasswordLengthException(); }
      // If no errors, proceed to insert user into DB
      $bdd = $this->db;
      $req = $bdd->prepare('INSERT INTO users(email, pw, active) VALUES(:email, :pw, :active)');
      $req->execute(array(
        'email' => $email,
        'pw' => sha1($pw),
        'active' => 1
      ));
      // No account confirmation needed: An ADMIN added & activated it directly
      header("Location:admin.php");
    }
    // Exceptions CATCH blocks
    catch (NotFilledUpFormException $e) { $e->showMessage(); }
    catch (InvalidEmailFormatException $e) { $e->showMessage(); }
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableEmailException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
  }

  public function getAll() {
    $bdd = $this->db;
    $req = $bdd->query("SELECT id, email, pw FROM users ORDER BY id ASC");
    return $req;
  }

  public function find($email) {
    $bdd = $this->db;
    $req = $bdd->query("SELECT COUNT(email) FROM users WHERE email='$email'");
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
          if ($this->find($email)) { throw new UnavailableEmailException(); }
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
        $_SESSION['confirmation'] = "Utilisateur modifié."; // message
        header("Location:edit.php");
      }
      else { throw new WrongUserIDException(); }
    }
    // Exceptions CATCH blocks
    catch (WrongUserLengthException $e) { $e->showMessage(); }
    catch (UnavailableEmailException $e) { $e->showMessage(); }
    catch (PasswordsDontMatchException $e) { $e->showMessage(); }
    catch (WrongPasswordLengthException $e) { $e->showMessage(); }
    catch (WrongUserIDException $e) { $e->showMessage(); }
  }

  public function delete($id) {
    try {
      if (is_null($id)) {
        throw new NotFilledUpIDException(); }
      $email = $this->getUserById($id);
      if ($this->find($email)){
        $bdd = $this->db;
        $this->db->exec('DELETE FROM users WHERE id = '.(int) $id);
        $_SESSION['error'] = "Utilisateur supprimé."; // message
        if (isset($_SESSION['inline'])) {
          unset($_SESSION['error']);
          unset($_SESSION['inline']);
        }
        // Redirect
        header("Location:admin.php");
      }
      else { throw new WrongUserIDException(); }
    }
    catch (NotFilledUpIDException $e) { $e->showMessage(); }
    catch (WrongUserIDException $e) { $e->showMessage(); }
  }

}

?>
