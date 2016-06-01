<?php
include_once '../lib/ListerManager.php';

// Add Item
if(isset($_POST['name'], $_GET['project_id'])){
  $name = trim($_POST['name']);
  $project_id = $_GET['project_id'];

  $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

  $lister = new ListerManager($db);
  $lister->add($name, $project_id);
}
else {

  // Add Project
  if(isset($_POST['title'])){
    $title = trim($_POST['title']);
    $email = $_SESSION['email'];

    $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

    $lister = new ListerManager($db);
    $lister->addProject($title, $email);
  }

  else { // Nothing to add
    if(isset($_SESSION['location'])) {
      header($_SESSION['location']);
    } else {
      header('Location:../authentification.php');
    }
  }

}

?>
