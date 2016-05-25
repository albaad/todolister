<?php
include_once '../lib/ListerManager.php';

if (isset($_GET['project_id'])) {
  $_SESSION['project_id'] = $_GET['project_id'];
  $_SESSION['project_title'] = $_GET['title'];

  $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $db = $connect->dbconnect();
  $reader = new ListerManager($db);
  $_SESSION['location'] = "Location: index-2.php";
  $project_id = $_SESSION['project_id'];
  $items = $reader->readList($project_id);
}



if(isset($_GET['as'], $_GET['item'])) {
	$as	= $_GET['as'];
	$item	= $_GET['item'];

	$connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
	$db = $connect->dbconnect();
	$lister = new ListerManager($db);
	$_SESSION['location'] = "Location: index.php";
	$lister->del($item, $as);
}
else {

	if(isset($_GET['pas'], $_GET['item'])) {
		$pas	= $_GET['pas'];
		$item	= $_GET['item'];

		$connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
		$db = $connect->dbconnect();
		$lister = new ListerManager($db);
		$_SESSION['location'] = "Location: index-pl.php";
		$lister->delProject($item, $pas);
	}
	else {
		header('Location: index.php');
	}

}

?>
