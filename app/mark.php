<?php
include_once '../lib/ListerManager.class.php';

// Mark Item
if(isset($_GET['as'], $_GET['item'])) {
    $as   = $_GET['as'];
    $item = $_GET['item'];

    $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

    $lister = new ListerManager($db);
    $lister->mark($item, $as);
  }
  else {

    // Mark Project
    if(isset($_GET['pas'], $_GET['item'])) {
      $pas   = $_GET['pas'];
      $item = $_GET['item'];

      $db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

      $lister = new ListerManager($db);
      $lister->markProject($item, $pas);
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
