<?php
  session_start();

  // Si SESSION active
  if(!empty($_SESSION['email'])) {
    header("location: accueil.php");
  }
 ?>
