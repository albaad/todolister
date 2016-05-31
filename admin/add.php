<?php
include 'lib/AdminManager.php';

$pageTitle = 'Ajouter utilisateur';
include 'inc/header.php';
$pageId = 3;
include 'inc/menu.php';

include 'inc/adminrights.php';
?>

  <div class="login">
    <h4>Ajouter utilisateur</h4>

    <div class="error"> <!-- erreur / message -->
      <?php
      if (isset($_SESSION['error'])) {
          echo $_SESSION['error'];
          unset($_SESSION['error']);
      }
      ?>
    </div>

    <div class="success">
      <?php
        if(isset($_SESSION['confirmation'])) {
          echo $_SESSION['confirmation'];
          unset($_SESSION['confirmation']);
        }
      ?>
    </div>

    <form class="" action="add.php" method="post">
      <input type="text" name="email" placeholder="email"></input>
      <input type='password' name='pass' placeholder='mdp'></input>

      <div class="espace"></div>

      <input type="submit" name="submit" value="Confirmer"></input>
    </form>
  </div>

<?php
  if(isset($_POST['submit'])) {
    $pseudo = $_POST['email'];
    $pw = $_POST['pass'];

    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:add.php';
    $user1 = $obj1->addUser($pseudo, $pw, $pw);
  }
?>

<?php include('inc/footer.php'); ?>
