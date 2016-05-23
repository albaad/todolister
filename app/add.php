<?php
include_once '../lib/ListerManager.php';

// Add Item
if(isset($_POST['name'], $_GET['project_id'])){
  $name = trim($_POST['name']);
  $project_id = $_GET['project_id'];

  $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $db = $connect->dbconnect();
  $lister = new ListerManager($db);
  $_SESSION['location'] = "Location: index.php";
  $lister->add($name, $project_id);
}
else {

  // Add Project
  if(isset($_POST['title'])){
    $title = trim($_POST['title']);
    $email = $_SESSION['email'];

    $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $db = $connect->dbconnect();
    $lister = new ListerManager($db);
    $_SESSION['location'] = "Location: index-pl.php";
    $lister->addProject($title, $email);
  }

  else { // Nothing to add
    header('Location: index.php');
  }

}

?>
