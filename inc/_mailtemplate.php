<?php
//class Template {}

$subtitle = "Récupérer votre mot de passe";
$email = "teleko@gmail.com";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>

    <div class="container">

      <div class="logo">
        <a href="http://localhost/proyectos/nfa021-tp/index.php">
          <i class="fa fa-list"></i>
          <span>&nbsp;To Do Lister</span>
        </a>
      </div>
      <div class="space-bar"></div>
      <span class="sub-title"><?php echo $subtitle; ?></span>
      <hr>
      <div class="content">
        <p>Hi <?php echo $email; ?>,</p>
        <p>Pour changer votre mot de passe, cliquez sur le lien suivant :</p>
        <p id="button">
          <a href='http://localhost/proyectos/nfa021-tp/changepassword.php?email=$email&key=$key'>
          Cliquez ICI pour créer un nouveau mot de passe</a>
        </p>
        <p id="signature">
          L'équipe To Do Lister
        </p>
      </div>

      <div id="footer" style="font-size: 9px;width: 100%;height: 40px;margin: 0 auto;text-align: center;padding: 20px 10px 0 10px;font-family: Arial;background-color: #EAEAEA;">
         Tous droits réservés @ To Do Lister 2016
      </div>

    </div>


<style media="screen">
  .container { max-width: 60%; padding: 10% 20%; text-align: center; font-family: Arial,helvetica,sans-serif; font-size: 15px; }
  .logo { display: block; margin-bottom: 10px; }
  .logo a { text-decoration: none; }
  .logo i, .logo span { color: #2ec866; }
  .logo i { font-size: 36px; }
  .logo span { font-family: 'Sofia', cursive; font-size: 34px; }
  .space-bar { display: block; min-width: 100%; height: 10px; background-color: #8d949a;}
  .sub-title { display: block; margin: 12px 0; color: #8d949a; font-size: 20px; }
  hr { display: block; height: 2px; border: 0; border-top: 2px solid #EAEAEA; margin: 1em 0; padding: 0;}
  .content { text-align: left;}
  .content p { margin-bottom: 12px; }
  #button { text-align: center;}
  #button a { text-decoration: none; background-color: #2ec966; color: #f3f3f3; display: inline-block; text-align: center; height: 25px; width: auto; padding: 10px 20px 5px 20px; }
  #button a:hover { background-color: #16aa56;}
  #signature { text-align: left; margin: 20px 0 30px 0;}
</style>

  </body>
</html>
