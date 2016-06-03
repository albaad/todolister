<?php
  if(!isset($_SESSION['email'])) {
    if(empty($_POST['email']) || empty($_POST['password'])) {
      // User not logged in
      $loggedin = false;
    }
  } else {
    $loggedin = true;
  }

  // If active SESSION
  if ($loggedin) {
    // If active SESSION = ADMIN SESSION
    if($_SESSION['email'] == 'admin') {
      header("location: admin/admin.php");
    } else {
      header("location: app/index.php");
    }
  }
?>
