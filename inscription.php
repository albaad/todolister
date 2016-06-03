<?php
  $pageTitle = 'Inscription';
  include 'inc/header.php';
  include_once 'lib/Mail.php';
  include 'inc/redirect.php'; // Redirect to app if user logged in
?>

  <div class='login'>

    <h2>Inscription</h2>

    <?php include 'inc/messages.php'; ?>

    <form name="register" method="POST" action="inscription.php">
      <input name='email' placeholder='E-Mail' type='text' value='<?php echo @$_SESSION['email_register']; ?>'></input>
      <input name='password' placeholder='Password' type='password' value='<?php echo @$_SESSION['pw_register']; ?>'></input>
      <input name='password2' placeholder='Répéter password' type='password'></input>
      <div class='agree'>
        <input id='agree' name='agree' type='checkbox'>
        <label for='agree'></label>J'ai lu et accepté les conditions d'utilisation
      </div>
      <input class='animated' type='submit' name='submit' value='Register'>
    </form>

    <a class='forgot' href='authentification.php'>Vous avez déjà un compte ?</a>

  </div>

  <?php
    // Destroy SESSION variables keeping form data in case of validation error
    unset($_SESSION['email_register']);
    unset($_SESSION['pw_register']);

    if(isset($_POST['submit'])) {
      $email = $_POST['email']; $_SESSION['email_register'] = $email;
      $pw = $_POST['password']; $_SESSION['pw_register'] = $pw;
      $pw2 = $_POST['password2'];

      if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2'])) {
        $_SESSION['error'] = 'Vous devez compléter tous les champs du formulaire !';
        header("Location:inscription.php");
      } else {
        if(isset($_POST['agree'])) {
          $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
          $usr = new UserManager($bdd);
          $_SESSION['location'] = 'Location:inscription.php';
          $user1 = $usr->register($email, $pw, $pw2);
        } else {
          $_SESSION['error'] = 'Veuillez accepter les conditions d\'utilisation';
          header("Location:inscription.php");
        }
      }
    }

    if(isset($_SESSION['key']) && isset($_SESSION['signup'])) {
      // Get variables
      $code = $_SESSION['key'];
      $email = $_SESSION['signup'];
      unset($_SESSION['signup']);
      unset($_SESSION['key']);

      // Send the email
      $confirm = new Mail();
      $confirm->setName('To Do Lister');
      $confirm->setEmail('noreply@todolister.com');
      $confirm->createSignature(false);
      $confirm->setSubject('Vérifiez votre adresse email');

      $subtitle = "Validez votre compte To Do Lister";
      $message = "Bienvenue à To Do Lister !";
      $text = "Pour compléter votre inscription, cliquez sur le lien suivant : ";
      $link = "http://localhost/todolister/confirm.php?email=$email&key=$code"; /////////////////////////// FIX LOCALHOST
      $linkText = "Cliquez ici pour activer votre compte :)";
      $confirm->setMessage($subtitle, $message, $text, $link, $linkText);

      $subjectPrefix = '[To Do Lister]';
      $emailTo = $email;
      $confirmationMsg = "Veuillez confirmer votre adresse e-mail via le lien que vous a été envoyé.";
      $errorMsg = "L'inscription a échoué";
      $_SESSION['location'] = 'Location:inscription.php';
      $confirm->sendMail($subjectPrefix, $emailTo, $confirmationMsg, $errorMsg);
    }

  ?>

<?php include('inc/footer.php'); ?>
