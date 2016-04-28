<?php
  session_start();

  $pageTitle = 'Contact';
  include 'inc/header.php';
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
        if(!empty($_SESSION['emailSent'])) {
          echo "Votre message a été envoyé";
          unset($_SESSION['emailSent']);
        }
      ?>
    </div>

    <form name="contact" method="POST" action="contact-form.php">
      <input name='name' placeholder='Nom' type='text' onblur="checkFields(this);"></input>
      <input name='email' placeholder='E-Mail' type='text' onblur="checkFields(this);"></input>

      <input id='subject' name='subject' placeholder='Sujet' type='text'></input>
      <textarea id='msg' name="msg" placeholder="Message"></textarea>

      <input class='animated' type='submit' value='Envoyer'>
    </form>

  </div>

<?php include 'inc/footer.php'; ?>
