<?php
  session_start();

  // Unset the cookie by setting it to a past time
  setcookie ('todolister-session', "", time() - 3600);

  // Verify user is logged in
  if(!empty($_SESSION['email'])){
    unset($_SESSION['email']);
    session_destroy();
  }

  session_destroy();
  header("Location:index.php");
?>
