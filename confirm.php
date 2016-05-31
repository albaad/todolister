<?php
session_start();
include_once 'admin/lib/Connection.php';

//setup some variables
$action = array();
$action['result'] = null;

//quick/simple validation
if(empty($_GET['email']) || empty($_GET['key'])){
    $action['result'] = 'error';
    $action['text'] = 'We are missing variables. Please double check your email.';
}

if($action['result'] != 'error') {

   //cleanup the variables
    $email = stripslashes(trim($_GET['email']));
    $key = stripslashes(trim($_GET['key']));

    //check if the key is in the database
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $req = $bdd->query("
      SELECT COUNT(*) FROM `confirm`
      WHERE `email` = '$email' AND `key` = '$key'
    ");
    $rows = $req->fetch(PDO::FETCH_NUM);
    $count = $rows[0];

    if($count == 1) {
        //get the confirm info

        $req = $bdd->query("
          SELECT `id`, `user_id` FROM `confirm`
          WHERE `email` = '$email' AND `key` = '$key'
        ");
        /*$req->execute([
          'email' => $email,
          'key' => $key
        ]);*/
        $check_key = $req->fetch();

        $id = $check_key['id'];
        $user_id = $check_key['user_id'];

        //confirm the email and update the users database
        //$update_users = mysql_query("UPDATE `users` SET `active` = 1 WHERE `id` = '$confirm_info[userid]' LIMIT 1") or die(mysql_error());
        $update_users = $bdd->query("UPDATE `users` SET `active` = 1 WHERE `id` = '$user_id'");

        //delete the confirm row
        //$delete = mysql_query("DELETE FROM `confirm` WHERE `id` = '$confirm_info[id]' LIMIT 1") or die(mysql_error());
        $delete = $bdd->query("DELETE FROM `confirm` WHERE `id` = '$id'");

        if($update_users){

            /*$action['result'] = 'success';
            $action['text'] = 'User has been confirmed. Thank-You!';*/

            //$_SESSION['message'] = 'Votre compte a été confirmé. Vous pouvez vous authentifier.';
            $_SESSION['confirmation'] = 'Votre compte a été confirmé. Vous pouvez vous authentifier.';
            //$_SESSION['error'] = $_SESSION['email']; //////// TEST
            header('location:authentification.php');

        } else{

            //$_SESSION['message'] = 'Une erreur a eu lieu pendant la confirmation de votre e-mail';
            $_SESSION['error'] = 'Une erreur a eu lieu pendant la confirmation de votre e-mail';
            //$action['result'] = 'error';

        }

    } else{

        //$action['result'] = 'error';
        //$action['text'] = 'The key and email is not in our database.';
        //$_SESSION['message'] = 'Une erreur a eu lieu pendant la confirmation de votre e-mail';
        $_SESSION['error'] = 'Une erreur a eu lieu pendant la confirmation de votre e-mail';

    }

}

?>
