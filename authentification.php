<?php
  include 'autorisation.php';

  $pageTitle = 'Accueil';
  include 'header.php';
?>

    <div class="login">
      <h2>Authentification</h2>

      <div class="erreur">
        <?php
          if (isset($_SESSION['message'])) {
              echo $_SESSION['message'];
              unset($_SESSION['message']);
          }
        ?>
      </div>

      <form name="register" method="POST" action="login.php">
        <input name='email' placeholder='E-Mail' type='text'></input>

        <input id='pw' name='password' placeholder='Password' type='password'></input>

        <div class="espace"></div>

        <input class='animated' type='submit' value='Login'>

      </form>

      <a class='forgot' href='inscription.php'>Vous n'avez pas encore un compte ?</a>
    </div>

<?php include('footer.php'); ?>
