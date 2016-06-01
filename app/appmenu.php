<!-- Add icon library -->
<?php
/*  include '../lib/UserManager.php';
  $conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $bdd = $conect->dbconnect();
  $usrmg = new UserManager($bdd);
  $loggedin = $usrmg->is_logged_in();*/
?>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/iconbarmenu.css" media="screen" title="no title" charset="utf-8">

<div class="icon-bar">
  <div class="logo-nav">
    <a href="index.php"><i class="fa fa-list"></i> <span>&nbsp;To Do Lister</span></a>
  </div>
  <div class="icon-nav">
    <a class="disabled" href="index.php"><i class="fa fa-home"></i></a>
    <a href="../contact.php"><i class="fa fa-envelope"></i></a>
    <a href="../settings.php"><i class="fa fa-cog"></i></a>
    <a href="../logout.php"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
