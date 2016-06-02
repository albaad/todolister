<?php
session_start();
include_once 'lib/AdminManager.php';

$email = 'admin';
$pw = "cnam";

$bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

$admn = new AdminManager($bdd);
$admin_exists = $admn->find($email);

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
