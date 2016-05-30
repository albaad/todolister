<?php
if($_SESSION['email'] != 'admin') {
  header("Location: ../index.php");
}
?>
