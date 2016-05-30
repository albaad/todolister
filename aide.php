<?php
  include 'inc/autorisation.php';

  $pageTitle = 'Index';
  include 'inc/header.php';
?>

  <div class="login">

      <h2>Aide</h2>

      <div class="aide-box">
        <div class="espace"></div>
        <ul>
          <li><i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;<a href="guide.php">Visite guidée</a></li>
          <li><div class="espace"></div>  </li>
          <li><i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;<a href="aide-pdf.php">Imprimez votre liste en format PDF</a></li>
        </ul>

        <div class="espace"></div>
        <div class="espace"></div>


      D'autres questions ?
      <div class="espace"></div>
      <a href="contact.php" class="contact-button">Contactez-nous ! </a>

    </div>

  </div>

<?php include('inc/footer.php'); ?>
