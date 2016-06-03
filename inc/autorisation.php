<?php
  // If active SESSION
  if(isset($_SESSION['email'])) {
    header("location: app/index.php");
  }
  if(!empty($_SESSION['email'])) {
    // If active SESSION = ADMIN SESSION
    if($_SESSION['email'] == 'admin') {
      header("location: admin/admin.php");
    } else {
      header("location: app/index.php");
    }
  }
 ?>
