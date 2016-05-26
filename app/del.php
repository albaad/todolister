<?php
include_once '../lib/ListerManager.php';

if(isset($_GET['as'], $_GET['item'])) {
	$as	= $_GET['as'];
	$item	= $_GET['item'];

	//$conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
	//$bdd = $conect->dbconnect();
	$bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

	$lister = new ListerManager($db);
	//$_SESSION['location'] = "Location: index.php";
	$lister->del($item, $as);
}
else {

	if(isset($_GET['pas'], $_GET['item'])) {
		$pas	= $_GET['pas'];
		$item	= $_GET['item'];

		//$conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
		//$bdd = $conect->dbconnect();
		$bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
		
		$lister = new ListerManager($db);
		//$_SESSION['location'] = "Location: index-pl.php";

		unset($_SESSION['project_id']);
		unset($_SESSION['project_title']);

		$lister->delProject($item, $pas);
	}

	else {
		//header('Location: index.php');
		if(isset($_SESSION['location'])) {
			header($_SESSION['location']);
		} else {
			header('Location:../authentification.php');
		}
	}

}

?>
