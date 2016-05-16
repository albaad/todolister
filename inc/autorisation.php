<?php
  //session_start();

  // If active SESSION
  if(!empty($_SESSION['email'])) {
    // If active SESSION = ADMIN SESSION
    if($_SESSION['email'] == 'admin') {
      header("location: admin/admin.php");
    }
    header("location: accueil.php");
  }
 ?>
