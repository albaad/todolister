<?php
  include 'autorisation.php';

  $pageTitle = 'Inscription';
  include 'header.php';
?>

  <div class='login'>

    <h2>Inscription</h2>

    <div class="erreur">
      <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
      ?>
    </div>

    <form name="register" method="POST" action="register.php">
      <input name='email' placeholder='E-Mail' type='text' onblur="checkFields(this);">
      </input>

      <input id='pw' name='password' placeholder='Password' type='password'></input>
      <input id='pw2' name='password2' placeholder='Repeat password' type='password' onblur="pwdCheck(this);"></input>

      <input id='dnaiss' name="dnaiss" placeholder='Date naissance YYYY-MM-DD' type="text"></input>

      <div class='agree'>
        <input id='agree' name='agree' type='checkbox'>
        <label for='agree'></label>J'ai lu et accepté les conditions d'utilisation
      </div>

      <input class='animated' type='submit' value='Register'>
    </form>

    <a class='forgot' href='authentification.php'>Vous avez déjà un compte ?</a>

  </div>

<?php include('footer.php'); ?>
