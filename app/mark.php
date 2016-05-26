<?php
include_once '../lib/ListerManager.php';

// Mark Item
if(isset($_GET['as'], $_GET['item'])) {
    $as   = $_GET['as'];
    $item = $_GET['item'];

    //$connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    //$db = $connect->dbconnect();
    $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

    $lister = new ListerManager($db);
    //$_SESSION['location'] = "Location: index.php";
    $lister->mark($item, $as);
  }
  else {

    // Mark Project
    if(isset($_GET['pas'], $_GET['item'])) {
      $pas   = $_GET['pas'];
      $item = $_GET['item'];

      //$connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
      //$db = $connect->dbconnect();
      $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

      $lister = new ListerManager($db);
      //$_SESSION['location'] = "Location: index-pl.php";
      $lister->markProject($item, $pas);
    }

    else { // Nothing to add
      //header('Location: index.php');
      if(isset($_SESSION['location'])) {
        header($_SESSION['location']);
      } else {
        header('Location:../authentification.php');
      }
    }

  }

?>
