<?php
include 'inc/autorisation.php';
$pageTitle = 'Récupérer mot de passe';
include 'inc/header.php';

//quick/simple validation
if(empty($_GET['email']) || empty($_GET['key'])){
    $_SESSION['error'] = 'We are missing variables. Please double check your email.';
    header('Location: authentification.php');
} else {
  $_SESSION['change'] = $_GET['email'];
  $_SESSION['key'] = $_GET['key'];
}
?>

  <div class="login">
    <h4>Modifier mot de passe</h4>

    <?php include 'inc/messages.php'; ?>

    <form class="" action="changepassword.php" method="post">
      <input type="text" name="email" value="<?php echo $_GET['email'];?>" hidden>
      <input name='pw' placeholder='Nouveau mdp' type='password'></input>
      <input name='pw2' placeholder='Nouveau mdp (encore)' type='password'></input>
      <div class="espace"></div>
      <input type="submit" name="submit" value="Confirmer" class="animated"></input>
    </form>
  </div>

<?php
if(isset($_POST['submit']) && !empty($_POST['pw']) && !empty($_POST['pw2'])) {
  $email = $_GET['email'];
  $pw = stripslashes(trim($_POST['pw']));
  $pw2 = $_POST['pw2'];
  $email = $_SESSION['change'];
  $key = $_SESSION['key'];
  unset($_SESSION['change']);
  unset($_SESSION['key']);

  //check if the key is in the database
  $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $req = $bdd->query("
    SELECT COUNT(*) FROM `confirm`
    WHERE `email` = '$email' AND `key` = '$key'
  ");
  $rows = $req->fetch(PDO::FETCH_NUM);
  $count = $rows[0];

  if($count == 1) {
      //get the confirm info
      $req = $bdd->query("
        SELECT `id`, `user_id` FROM `confirm`
        WHERE `email` = '$email' AND `key` = '$key'
      ");
      $check_key = $req->fetch();
      $confirm_id = $check_key['id'];
      // Delete confirm row0
      $delete = $bdd->query("DELETE FROM `confirm` WHERE `id` = '$confirm_id'"); // OK

      // Update users table with new password
      $pw = sha1($pw);
      $update_users = $bdd->query("UPDATE `users` SET `pw` = '$pw' WHERE `email` = '$email'");

      if($update_users){

          $_SESSION['confirmation'] = 'Votre mot de passe a été actualisé';
          header('location:authentification.php');

      } else {
          $_SESSION['error'] = 'Une erreur a eu lieu pendant la confirmation de votre e-mail';
      }

  }

}

?>
