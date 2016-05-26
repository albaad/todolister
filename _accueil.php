<?php
//  session_start();
  $pageTitle = 'Accueil';
  include 'inc/header.php';

  // Verifies user is logged in
  if(empty($_SESSION['email'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
      // User not logged in
      session_destroy();
      header("Location:authentification.php");
    } else { // User logged in
    // Session variables for email
      $_SESSION['email'] = $_POST['email'];
    }
  }
  if($_SESSION['email'] == 'admin') {
    header("location: admin/admin.php");
  } 
?>

<div class="login">

  <p style="text-align: center; color: #16AA56;">Bienvenue
    <span style="color: #6D7781;"><?php echo $_SESSION['email']; ?></span></p>

  <a class='logout' href='logout.php'>Déconnexion</a>

</div>

<?php include 'inc/footer.php'; ?>
