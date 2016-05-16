<?php
  $pageTitle = 'Contact';
  include 'inc/header.php';
  include 'lib/ContactFormulaire.php';
  include_once 'lib/UserManager.php';
?>

  <div class='login'>

    <h3>Nous contacter</h3>

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
        if(!empty($_SESSION['confirmation'])) {
          echo $_SESSION['confirmation'];
          unset($_SESSION['confirmation']);
        }
      ?>
    </div>

    <form name="contact" method="POST" action="contact.php">
      <input name='name' placeholder='Nom' type='text'></input>
      <input name='email' placeholder='E-Mail' type='text'></input>

      <input id='subject' name='subject' placeholder='Sujet' type='text'></input>
      <textarea id='msg' name="msg" placeholder="Message"></textarea>

      <input class='animated' name='submit' type='submit' value='Envoyer'>
    </form>

  </div>

<?php
if(isset($_POST['submit'])) {
  $contact = new ContactFormulaire();
  if($contact->testForm()) {
    $contact->retrieveForm();
    $contact->sendMail();
  }
}
?>

<?php include 'inc/footer.php'; ?>
