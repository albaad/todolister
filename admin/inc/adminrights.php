<?php
  if(!isset($_SESSION['email']) || $_SESSION['email'] != 'admin') {
    header("location: ../accueil.php");
  }
 ?>
