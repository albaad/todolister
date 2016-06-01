<?php
include 'lib/AdminManager.php';

$pageTitle = 'Modifier utilisateur';
include 'inc/header.php';
$pageId = 4;
include 'inc/menu.php';

include 'inc/adminrights.php';
?>

  <div class="login">
    <h4>Modifier utilisateur</h4>

    <?php include '../inc/messages.php'; ?>

    <form class="" action="edit.php" method="post">
      <input type="text" name="id" placeholder="id"></input>
      <input type="text" name="email" placeholder="Nouvel email"></input>
      <input name='pass' placeholder='Nouveau mdp' type='password'></input>

      <div class="espace"></div>

      <input type="submit" name="submit" value="Confirmer"></input>
    </form>
  </div>

<?php
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $pw = $_POST['pass'];

    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $admin = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:edit.php';
    $user1 = $admin->update($id, $email, $pw);
    echo $user1;
  }
?>

<?php include('inc/footer.php'); ?>
