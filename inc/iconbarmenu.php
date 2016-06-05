<?php
  include 'lib/UserManager.class.php';

  $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $usrmg = new UserManager($bdd);
  $loggedin = $usrmg->is_logged_in();
  $usrmg = null;
?>

<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/iconbarmenu.css" media="screen" title="no title" charset="utf-8">

<div class="icon-bar">
  <div class="logo-nav">
    <a href="app/index.php" alt="Accueil"><i class="fa fa-list"></i> <span>&nbsp;To Do Lister</span></a>
  </div>
  <div class="icon-nav">
    <a <?php if ($pageTitle == 'To Do Lister') echo 'class="disabled"'; ?> href="app/index.php" title="Accueil"><i class="fa fa-home"></i></a>
    <a <?php if ($pageTitle == 'Authentification' || $pageTitle == 'Inscription') echo 'class="disabled"'; if ($loggedin) echo 'class="hidden"'; ?> href="inscription.php" title="Inscription"><i class="fa fa-user"></i></a>
    <a <?php if ($pageTitle == 'Contact') echo 'class="disabled"'; ?> href="contact.php" title="Contact"><i class="fa fa-envelope"></i></a>
    <a <?php if ($pageTitle == 'Parametres') echo 'class="disabled"'; if (!$loggedin) echo 'class="hidden"'; ?> href="settings.php" title="Paramètres"><i class="fa fa-cog"></i></a>
    <a <?php if ($pageTitle == 'Aide') echo 'class="disabled"'; ?> href="aide.php" title="Aide"><i class="fa fa-info"></i></a>
    <a <?php if (!$loggedin) echo 'class="hidden"'; ?> href="logout.php" title="Logout"><i class="fa fa-sign-out"></i></a>
  </div>
</div>
