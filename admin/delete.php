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

    <div class="error"> 
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
    $user1 = $obj1->delete($id);
  }
?>

<?php include('inc/footer.php'); ?>
