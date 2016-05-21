<?php
include_once '../lib/ListerManager.php';

if(isset($_POST['name'])){
  $name = trim($_POST['name']);

  // TEMP :
  $project_id = NULL; // upgrade: store items by project
  //

  $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $db = $connect->dbconnect();
  $lister = new ListerManager($db);
  $_SESSION['location'] = "Location: index.php";
  $lister->add($name, $project_id);
}

?>
