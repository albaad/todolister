<?php
  $pageTitle = 'Contact';
  include 'inc/header.php';
  include 'lib/Mail.php';
  include_once 'lib/UserManager.php';

  $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $usrmg = new UserManager($bdd);
  $loggedin = $usrmg->is_logged_in();
?>

  <div class='login'>

    <h3>Nous contacter</h3>

    <?php include 'inc/messages.php'; ?>

    <form name="contact" method="POST" action="contact.php">
      <input name='name' placeholder='Nom' type='text'></input>
      <input name='email' placeholder='E-Mail' type='text' value='<?php if ($loggedin) echo $_SESSION['email'];?>'></input>

      <input id='subject' name='subject' placeholder='Sujet' type='text'></input>
      <textarea id='msg' name="msg" placeholder="Message"></textarea>

      <input class='animated' name='submit' type='submit' value='Envoyer'>
    </form>

  </div>

<?php
if(isset($_POST['submit'])) {
  $contact = new Mail();
  if($contact->testForm()) {
    $contact->retrieveForm();
    $contact->createSignature(true);
    $subjectPrefix = '[To Do Lister]';
    $emailTo = '<test.dev.at@gmail.com>';
    $confirmationMsg = "Votre message a été envoyé";
    $errorMsg = "L'envoi du message a échoué";
    $_SESSION['location'] = 'Location: contact.php';
    $contact->sendMail($subjectPrefix, $emailTo, $confirmationMsg, $errorMsg);
  }
}
?>

<?php include 'inc/footer.php'; ?>
<?php
// Built and tested with/for PHP 7 and 5.6.16
// For localhost testing, edit php.ini:
/*
      [mail function]
      ; For Win32 only.
      ; http://php.net/smtp
      SMTP = smtp.orange.fr
      ; http://php.net/smtp-port
      smtp_port = 25
       
      ; For Win32 only.
      ; http://php.net/sendmail-from
      sendmail_from = "xx.xx@orange.fr"
*/
?>
