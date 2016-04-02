<?php // On démarre la session
  session_start();

  include 'header.php';

  // Vérifie que l'utilisateur est authentifié
  if(empty($_SESSION['email'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
      // Utilisateur pas authentifié
      session_destroy();
      header("Location:authentification.html");
    } else { // Utilisateur authentifié
    // Création des variables de session user et mdp
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['password'] = $_POST['password'];
    }
  }
?>

<div class="login">

  <p style="text-align: center; color: #16AA56;">Bienvenue
    <span style="color: #6D7781;"><?php echo $_SESSION['email']; ?></span></p>

  <a class='logout' href='logout.php'>Déconnexion</a>

</div>

<?php include 'footer.php'; ?>
