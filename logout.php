<?php
  session_start();
  //$pageTitle = 'Logout';
  // Vérifie que l'utilisateur est authentifié
  if(!empty($_SESSION['email'])){
    unset($_SESSION['email']);
    session_destroy();
  }
  header("Location:authentification.php");
?>
