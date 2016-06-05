<?php
  include_once 'lib/Connection.php';

  // To re-login user if cookie has been created:
  if (isset($_COOKIE['todolister'])) {

    $cookie = $_COOKIE['todolister'];

    $hash = base64_decode ($cookie);
    list($email, $hashed_password) = explode (':', $hash);

    // Fetch real password from database based on username ($email)
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $req = $bdd->prepare("
      SELECT pw FROM users
      WHERE email=:email
    ");
    $req->execute([
      'email' => $email
    ]);
    $donnees = $req->fetch();
    $password = $donnees['pw'];

    // $password is already hashed (sha1)
    if (sha1($password, substr($password, 0, 2)) == $hashed_password) {
        // you can consider use as logged in
        $_SESSION['email'] = $email;
        header('Location: app/index.php');
    }

  }
?>
