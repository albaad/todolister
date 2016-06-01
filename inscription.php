<?php
  include 'inc/autorisation.php';
  $pageTitle = 'Inscription';
  include 'inc/header.php';
  include_once 'lib/Mail.php';
?>

  <div class='login'>

    <h2>Inscription</h2>

    <div class="error">
      <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
      ?>
    </div>
    <div class="success">
      <?php
        if(isset($_SESSION['confirmation'])) {
          echo $_SESSION['confirmation'];
          unset($_SESSION['confirmation']);
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
        $_SESSION['error'] = 'Veuillez accepter les conditions d\'utilisation';
        header("Location:inscription.php");
      }
    }

    if(isset($_SESSION['key']) && isset($_SESSION['signup'])) {
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
      $link = "http://localhost/proyectos/nfa021-tp/confirm.php?email=$email&key=$code";
      $linkText = "Cliquez ici pour activer votre compte :)";
      $confirm->setMessage($subtitle, $message, $text, $link, $linkText);
      /*$confirm->setMessage("
        Bonjour $email,
        <br /><br />
        Bienvenue à To Do Lister!<br/><br/>
        Pour compléter votre inscription, cliquez sur le lien suivant :
        <br /><br />
        <a href='http://localhost/proyectos/nfa021-tp/confirm.php?email=$email&key=$code'>Cliquez ICI pour activer votre compte :)</a>
        <br /><br />
        Merci,
      ");*/ /////////////////////////// FIX LOCALHOST
      $subjectPrefix = '[To Do Lister]';
      $emailTo = $email;
      $confirmationMsg = "Veuillez confirmer votre adresse e-mail via le lien que vous a été envoyé.";
      $errorMsg = "L'inscription a échoué";
      $_SESSION['location'] = 'Location:inscription.php';
      $confirm->sendMail($subjectPrefix, $emailTo, $confirmationMsg, $errorMsg);
    }

  ?>

<?php include('inc/footer.php'); ?>
