<?php
  include 'inc/autorisation.php';

  $pageTitle = 'Inscription';
  include 'inc/header.php';
?>

  <div class='login'>

    <h2>Inscription</h2>

    <div class="error">
      <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
      ?>
    </div>

    <form name="register" method="POST" action="inscription.php">
      <input name='email' placeholder='E-Mail' type='text'></input>
      <input name='password' placeholder='Password' type='password'></input>
      <input name='password2' placeholder='Repeat password' type='password'></input>
      <div class='agree'>
        <input id='agree' name='agree' type='checkbox'>
        <label for='agree'></label>J'ai lu et accepté les conditions d'utilisation
      </div>
      <input class='animated' type='submit' name='submit' value='Register'>
    </form>

    <a class='forgot' href='authentification.php'>Vous avez déjà un compte ?</a>

  </div>

  <?php
    if(isset($_POST['submit'])) {
      $email = $_POST['email'];
      $pw = $_POST['password'];
      $pw2 = $_POST['password2'];

      if(isset($_POST['agree'])) {
        $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
        $obj1 = new UserManager($bdd);
        $_SESSION['location'] = 'Location:inscription.php';
        $user1 = $obj1->register($email, $pw, $pw2);
      } else {
        $_SESSION['message'] = 'Veuillez accepter les conditions d\'utilisation';
        header("Location:inscription.php");
      }
    }
  ?>

<?php include('inc/footer.php'); ?>
