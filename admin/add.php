<?php
  include 'lib/AdminManager.class.php';

  $pageTitle = 'Ajouter utilisateur';
  include 'inc/header.php';
  $pageId = 3;
  include 'inc/menu.php';

  include 'inc/adminrights.php';
?>

  <div class="login">
    <h4>Ajouter utilisateur</h4>

    <?php include '../inc/messages.php'; ?>

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
