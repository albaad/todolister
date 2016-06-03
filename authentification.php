<?php
  $pageTitle = 'Authentification';
  include 'inc/header.php';
  include 'inc/redirect.php'; // Redirect to app if user logged in
?>

    <div class="login">

      <h2>Authentification</h2>

      <?php include 'inc/messages.php'; ?>

      <form name="register" method="POST" action="authentification.php">
        <input name='email' placeholder='E-Mail' type='text' value='<?php echo @$_SESSION['email_login']; ?>'></input>
        <input name='password' placeholder='Password' type='password'></input>
        <div class="espace"></div>
        <input class='animated' type='submit' name='submit' value='Login'>
      </form>

      <a class='forgot' href='inscription.php'>Vous n'avez pas encore un compte ?</a>

      <a class='forgot-pw' href='forgotpassword.php'>Vous avez oublié votre mot de passe ?</a>

    </div>

    <?php
      // Destroy SESSION variable keeping form data in case of validation error
      unset($_SESSION['email_login']);

      if(isset($_POST['submit'])) {
        $email = $_POST['email'];  $_SESSION['email_login'] = $email;
        $pw = $_POST['password'];

        $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
        $obj1 = new UserManager($bdd);
        $_SESSION['location'] = 'Location:authentification.php';
        $obj1->login($email, $pw);
      }
    ?>

<?php include('inc/footer.php'); ?>
