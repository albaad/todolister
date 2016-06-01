<?php
include 'inc/autorisation.php';
$pageTitle = 'Récupérer mot de passe';
include 'inc/header.php';
include_once 'lib/Mail.php';
?>

  <div class='login'>

    <h5>Récupérez votre mot de passe</h5>

    <?php include 'inc/messages.php'; ?>

    <form name="forgot" method="POST" action="forgotpassword.php">
      <input name='email' placeholder='E-Mail' type='text'></input>
      <input class='animated' type='submit' name='submit' value='Register'>
    </form>

  </div>

  <?php
  if(isset($_POST['submit']) && !empty($_POST['email'])) {
    // Generate key if given email correspond to existing account
  	$email = $_POST['email'];
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $usr = new UserManager($bdd);
    $_SESSION['location'] = 'Location:forgotpassword.php';
    $user1 = $usr->forgottenPassword($email);
	}
  if(isset($_SESSION['forgot']) && isset($_SESSION['key'])) {
        echo 'inside 2nd if';
    $key = $_SESSION['key'];
    unset($_SESSION['key']);
    unset($_SESSION['forgot']);
    // Send the email
    $confirm = new Mail();
    $confirm->setName('L\'équipe To Do Lister');
    $confirm->setEmail('noreply@todolister.com');
    $confirm->createSignature(false);
    $confirm->setSubject('Récupérez votre mot de passe');

    $subtitle = "Récupérez votre mot de passe To Do Lister";
    $message = "Bonjour $email,";
    $text = "Pour changer votre mot de passe, cliquez sur le lien suivant : ";
    $link = "http://localhost/proyectos/nfa021-tp/changepassword.php?email=$email&key=$key";
    $linkText = "Cliquez ici pour créer un nouveau mot de passe";
    $confirm->setMessage($subtitle, $message, $text, $link, $linkText);
    /*$confirm->setMessage("
      Bonjour $email,
      <br /><br />
      Vous avez oublié votre mot de passe ?<br/><br/>
      Pour le changer, cliquez sur le lien suivant :
      <br /><br />
      <a href='http://localhost/proyectos/nfa021-tp/changepassword.php?email=$email&key=$key'>
      Cliquez ICI pour créer un nouveau mot de passe</a>
      <br /><br />
    "); */ ///////////////////////////////////////////////////////////////
    $subjectPrefix = '[To Do Lister]';
    $emailTo = $email;
    $confirmationMsg = "Changez votre mot de passe via le lien que vous a été envoyé.";
    $errorMsg = "L'envoi du mail a échoué";
    $_SESSION['location'] = 'Location:forgotpassword.php';
    $confirm->sendMail($subjectPrefix, $emailTo, $confirmationMsg, $errorMsg);
  }

?>

<?php include('inc/footer.php'); ?>
