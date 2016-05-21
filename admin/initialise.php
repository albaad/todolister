<?php
session_start();
include_once 'lib/ADminManager.php';

$email = 'admin';
$pw = "cnam";

$conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
$bdd = $conect->dbconnect();
$obj1 = new AdminManager($bdd);
$admin_exists = $obj1->find($email);

if(!$admin_exists) {
  $bdd = $this->db;
  $req = $bdd->prepare("
    INSERT INTO users(email, pw)
    VALUES(:email, :pw)
  ");
  $req->execute([
    'email' => $email,
    'pw' => sha1($pw)
  ]);
}

 ?>
