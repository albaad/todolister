<?php session_start();

// Si SESSION pas active et POST correct
if((empty($_SESSION['email']) || empty($_SESSION['pw'])) && (!empty($_POST['email']) && !empty($_POST['password']))){
/* LOGIN */

  // Vérifie que les champs ne sont pas vides
  if(empty($_POST["email"]) || empty($_POST["password"])) {
  	echo "Vous devez compléter tous les champs du formulaire !";
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
         header("location: accueil.php");
       } else {
         echo $error = "Login ou mot de passe erroné !";
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
