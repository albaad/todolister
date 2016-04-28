<?php

  include 'inc/autorisation.php';

  function verif($email, $pw){
    // Connexion à la base
    try {
      $bdd = new PDO('mysql:host=localhost;dbname=nfa021;charset=utf8', 'root', '');
      $req = $bdd->query("SELECT COUNT(email) FROM membres WHERE email='$email' AND pw='$pw'");
      $rows = $req->fetch(PDO::FETCH_NUM);
      $count = $rows[0];
      // Si res = $email et $pw, 1 resultat
       if($count == 1) {
         $_SESSION['email'] = $email;

         // -------------- Si ADMIN :
         if($email == 'admin') {
           $_SESSION['level'] = 'admin';
         }
         // --------------

         return true;
       } else {
         return false;
       }
     }
    catch (Exception $e){
        session_destroy();
        die('Erreur:'.$e->getMessage());
    }
    return false;
  }

  /* LOGIN */

    // Vérifie que les champs ne sont pas vides
    if(empty($_POST["email"]) || empty($_POST["password"])) {
      $_SESSION['error'] = "Vous devez compléter tous les champs du formulaire !";
      header("Location:authentification.php");
    }
    else {
    	$email = $_POST["email"];
    	$pw = sha1($_POST["password"]);

      $existe = verif($email, $pw);
      if ($existe)
        header("Location:accueil.php");
      else {
        $_SESSION['error'] = "Login ou mot de passe erroné !";
        header("Location:authentification.php");
      }
    }

?>
