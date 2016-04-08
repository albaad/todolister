<?php

	include 'inc/autorisation.php';

/*function createUser($email){
   $sql = "SELECT count(email) FROM members WHERE email='$email'" ;

   $result = mysql_result(mysql_query($sql),0) ;

   if( $result > 0 ){
    die( "There is already a user with that email!" ) ;
   }//end if
}*/

// Vérifie que les champs ne sont pas vides
	if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["dnaiss"])) {
		$_SESSION['message'] = "Vous devez compléter tous les champs du formulaire !";
		header('Location:inscription.php');
	}
	else {
		$email = $_POST["email"];
		$pw = $_POST["password"];
		$dnaiss = $_POST["dnaiss"];
	// vérifie que les conditions utilisation ont été acceptées
		if($_POST["agree"]!="on"){
			$_SESSION['message'] = "Vous devez accepter les conditions d'utilisation.";
			header('Location:inscription.php');
		}
		// Champs remplis et conditions acceptées
		else {
			// Vérifie format adresse email
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $emailErr = "Format email invalide";
			  $_SESSION['message'] = $emailErr;
				header('Location:inscription.php');
			}
			else {

				// Vérifie format date YYYY-MM-DD
				if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dnaiss)) {
							$_SESSION['message'] = "Format de date invalide";
							header('Location:inscription.php');
			    }
			    else {

				    // Connexion à la base
					try {
						$bdd = new PDO('mysql:host=localhost;dbname=nfa021;charset=utf8', 'root', '');
						echo "Connection à la BDD OK<br/>";
					}
					catch (Exception $e){
						session_destroy();
						die('Erreur:'.$e->getMessage());
					}

					// Vérifie adresse email unique
					$req=$bdd->query("SELECT COUNT(email) FROM membres WHERE email='$email'");
					$rows = $req->fetch(PDO::FETCH_NUM);
					$count = $rows[0];

					 if($count == 1) {
					    $_SESSION['message'] = "Un compte existant est déjà lié à cet email";
							header("Location:inscription.php");
					 }
					 else {
						// Insérer ligne
						$req = $bdd->prepare('INSERT INTO membres(email, pw, dnaiss) VALUES(:email, :pw, :dnaiss)');
						$req->execute(array(
							'email' => $email,
							'pw' => sha1($pw),
							'dnaiss' => $dnaiss
						));

						$_SESSION['email'] = $email;

						header("Location:accueil.php");
					}
				}
			}
		}
	}

?>
