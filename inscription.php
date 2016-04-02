<?php session_start();

/*function createUser($email){
   $sql = "SELECT count(email) FROM members WHERE email='$email'" ;

   $result = mysql_result(mysql_query($sql),0) ;

   if( $result > 0 ){
    die( "There is already a user with that email!" ) ;
   }//end if
}*/

// Vérifie que les champs ne sont pas vides
if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password2"]) || empty($_POST["dnaiss"])) {
	echo "Vous devez compléter tous les champs du formulaire !";
}
else {
	$email = $_POST["email"];
	$pw = $_POST["password"];
	$dnaiss = $_POST["dnaiss"];
// vérifie que les conditions utilisation ont été acceptées
	if($_POST["agree"]!="on"){
		echo "Vous devez accepter les conditions d'utilisation.";
	}
	// Champs remplis et conditions acceptées
	else {
		// Vérifie format adresse email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "Format email invalide";
		  echo $emailErr;
		}
		else {

			// Vérifie format date YYYY-MM-DD
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dnaiss)) {
		        echo "Format de date invalide";
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

				// Vérifie adresse email unique ////////////////////////////
				/*$sql=$bdd->prepare("SELECT COUNT(*) FROM membres(email, pw, dnaiss) WHERE email=$email");
				$req1 = $sql->query(array('email' => $email));
				$count = $sql->fetchColumn();
				//echo $count;
				 if($count >= 1) {
				    echo "Un compte existant est déjà lié à cet email";
				 }
				 else {*/
					// Insérer ligne
					$req = $bdd->prepare('INSERT INTO membres(email, pw, dnaiss) VALUES(:email, :pw, :dnaiss)');
					$req->execute(array(
						'email' => $email,
						'pw' => sha1($pw),
						'dnaiss' => $dnaiss
					));

					$_SESSION['email'] = $email;

					header("Location:accueil.php");
				//}
			}
		}
	}
}

?>
