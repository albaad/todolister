<?php session_start();

// Si SESSION pas active et POST correct
if(empty($_SESSION['email']) || empty($_SESSION['pw'])){
/* LOGIN */

  // Vérifie que les champs ne sont pas vides
  if(empty($_POST["email"]) || empty($_POST["password"])) {
    $_SESSION['message'] = "Vous devez compléter tous les champs du formulaire !";
    header("Location:authentification.php");
  }
  else {
  	$email = $_POST["email"];
  	$pw = sha1($_POST["password"]);

  	// Connexion à la base
  	try {
  		$bdd = new PDO('mysql:host=localhost;dbname=nfa021;charset=utf8', 'root', '');
  		// echo "Connection à la BDD OK<br/>";

      $req = $bdd->query("SELECT COUNT(email) FROM membres WHERE email='$email' AND pw='$pw'");
      $rows = $req->fetch(PDO::FETCH_NUM);
      $count = $rows[0];
      // Si res = $email et $pw, 1 resultat
       if($count == 1) {
         $_SESSION['email'] = $email;
         header("Location:accueil.php");
       } else {
         $_SESSION['message'] = "Login ou mot de passe erroné !";
         header("Location:authentification.php");
       }
     }

    catch (Exception $e){
  			session_destroy();
  			die('Erreur:'.$e->getMessage());
  	}
  }
}

// Si SESSION active
if(!empty($_SESSION['email'])) {
  header("location: accueil.php");
}

?>
