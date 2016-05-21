<?php
include_once '../lib/ListerManager.php';

if(isset($_GET['as'], $_GET['item'])) {
	$as	= $_GET['as'];
	$item	= $_GET['item'];

	$connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
	$db = $connect->dbconnect();
	$lister = new ListerManager($db);
	$_SESSION['location'] = "Location: index.php";
	$lister->del($item, $as);
}

?>
