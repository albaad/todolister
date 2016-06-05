<?php
  $pageTitle = 'Contact';
  include 'inc/header.php';
  include 'lib/Mail.class.php';
  include_once 'lib/UserManager.class.php';

  $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $usrmg = new UserManager($bdd);
  $loggedin = $usrmg->is_logged_in();
?>

  <div class='login'>

    <h3>Nous contacter</h3>

    <?php include 'inc/messages.php'; ?>

    <form name="contact" method="POST" action="contact.php">
      <input name='name' placeholder='Nom' type='text' value='<?php echo @$_SESSION['name_contact']; ?>'></input>
      <input name='email' placeholder='E-Mail' type='text' value='<?php if ($loggedin) echo $_SESSION['email'];?>'></input>

      <input id='subject' name='subject' placeholder='Sujet' type='text' value='<?php echo @$_SESSION['subject_contact']; ?>'></input>
      <textarea id='msg' name="msg" placeholder="Message" value='<?php echo @$_SESSION['msg_contact']; ?>'></textarea>

      <input class='animated' name='submit' type='submit' value='Envoyer'>
    </form>

  </div>

  <?php
    // Destroy SESSION variables keeping form data in case of validation error
    unset($_SESSION['name_contact']);
    unset($_SESSION['subject_contact']);
    unset($_SESSION['msg_contact']);

    if(isset($_POST['submit'])) {
      $_SESSION['name_contact'] = @$_POST['name'];
      $_SESSION['subject_contact'] = @$_POST['subject'];
      $_SESSION['msg_contact'] = @$_POST['msg'];

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
    } else {
          $_SESSION['location'] = 'Location: contact.php';
    }
  ?>

<?php include 'inc/footer.php'; ?>
<?php
// Built and tested with/for PHP 7 and 5.6.16
// For localhost testing, edit php.ini:
// (example for French ISP "Orange")
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
