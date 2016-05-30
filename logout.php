<?php
  session_start();
  // Verify user is logged in
  if(!empty($_SESSION['email'])){
    unset($_SESSION['email']);
    session_destroy();
  }
  header("Location:index.php");
?>
