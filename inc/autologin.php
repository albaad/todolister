<?php
  include_once 'lib/Connection.php';

  // To re-login user if cookie has been created:
  if (isset($_COOKIE['todolister-session'])) {
    $cookie = $_COOKIE['todolister-session'];
    $_SESSION['email'] = $cookie;
    header('Location: app/index.php');


    //$hash = base64_decode ($cookie);
    //list($email, $hashed_password) = explode (':', $hash);

    // Fetch real password from database based on username ($email)
    //$bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    /*$req = $bdd->prepare("
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
    } */

    /***$req = $bdd->prepare("
      SELECT COUNT(email) FROM users
      WHERE email=:email
    ");
    $req->execute([
      'email' => $cookie
    ]);
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];
    // IF res = $email, 1 result
     if($count == 1) {
       $_SESSION['email'] = $cookie;
       header('Location: app/index.php');
     } else {
       return false;
     }

*/
  }
?>
