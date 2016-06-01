<?php
  include 'lib/AdminManager.php';

  $pageTitle = 'Supprimer utilisateur';
  include 'inc/header.php';
  $pageId = 2;
  include 'inc/menu.php';

  include 'inc/adminrights.php';
?>

  <div class="login">
    <h5>Supprimer utilisateur</h5>

    <?php include '../inc/messages.php'; ?>

    <form class="" action="delete.php" method="post">
      <input type="text" name="id" placeholder="id"></input>

      <div class="espace"></div>

      <input type="submit" name="submit" value="Confirmer"></input>
    </form>
  </div>

<?php
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:delete.php';
    $user1 = $obj1->delete($id);
    echo $user1;
  }
  if(isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:admin.php';
    $_SESSION['inline'] = true;
    $user1 = $obj1->delete($id);
  }
?>

<?php include('inc/footer.php'); ?>
