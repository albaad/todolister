<?php
include 'lib/AdminManager.php';

$pageTitle = 'Ajouter utilisateur';
include 'inc/header.php';
$pageId = 3;
include 'inc/menu.php';
?>

  <div class="login">
    <h4>Ajouter utilisateur</h4>

    <div class="erreur">
      <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
      ?>
    </div>

    <form class="" action="add.php" method="post">
      <input type="text" name="pseudo" placeholder="pseudo"></input>
      <input type='password' name='pass' placeholder='mdp'></input>

      <div class="espace"></div>

      <input type="submit" name="submit" value="Confirmer"></input>
    </form>
  </div>

<?php
  if(isset($_POST['submit'])) {
    $pseudo = $_POST['pseudo'];
    $pw = $_POST['pass'];
    $conect = ConnectionSingleton::getInstance('localhost', 'nfa021', 'utf8', 'root', '');
    $bdd = $conect->dbconnect();
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:add.php';
    $user1 = $obj1->addUser($pseudo, $pw, $pw);
  }
?>

<?php include('inc/footer.php'); ?>
