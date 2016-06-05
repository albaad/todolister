<?php
include_once '../lib/ListerManager.class.php';

if(isset($_GET['as'], $_GET['item'])) {
	$as	= $_GET['as'];
	$item	= $_GET['item'];

	$db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

	$lister = new ListerManager($db);
	$lister->del($item, $as);
}
else {

	if(isset($_GET['pas'], $_GET['item'])) {
		$pas	= $_GET['pas'];
		$item	= $_GET['item'];

		$db = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

		$lister = new ListerManager($db);

		unset($_SESSION['project_id']);
		unset($_SESSION['project_title']);

		$lister->delProject($item, $pas);
	}

	else {
		if(isset($_SESSION['location'])) {
			header($_SESSION['location']);
		} else {
			header('Location:../authentification.php');
		}
	}

}

?>
