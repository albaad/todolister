<?php
  include 'inc/autorisation.php';

  $pageTitle = 'Authentification';
  include 'inc/header.php';
?>

    <div class="login">

      <h2>Authentification</h2>

      <?php include 'inc/messages.php'; ?>

      <form name="register" method="POST" action="authentification.php">
        <input name='email' placeholder='E-Mail' type='text'></input>
        <input name='password' placeholder='Password' type='password'></input>
        <div class="espace"></div>
        <input class='animated' type='submit' name='submit' value='Login'>
      </form>

      <a class='forgot' href='inscription.php'>Vous n'avez pas encore un compte ?</a>

      <a class='forgot-pw' href='forgotpassword.php'>Vous avez oublié votre mot de passe ?</a>

    </div>

    <?php
      if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pw = $_POST['password'];

        $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
        $obj1 = new UserManager($bdd);
        $_SESSION['location'] = 'Location:authentification.php';
        $obj1->login($email, $pw);
      }
    ?>

<?php include('inc/footer.php'); ?>
