<?php
  session_start();
  // Vérifie que l'utilisateur est authentifié
  if(!empty($_SESSION['email'])){
    session_destroy();
  }
  header("Location:authentification.php");
?>
