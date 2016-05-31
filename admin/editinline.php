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

    <?php
      if(isset($_GET['id'])) {
        $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
        $obj1 = new AdminManager($bdd);
        $_SESSION['location'] = 'Location:editinline.php';
        $user1 = $obj1->getUserById($_GET['id']);
    ?>

        <form class="" action="editinline.php" method="post">
          <input type="text" name="id" placeholder="id" value="<?php echo $_GET['id'];?>"></input>
          <input type="text" name="email" placeholder="Nouvel email" value="<?php echo $user1;?>"></input>
          <input name='pass' placeholder='Nouveau mdp' type='password'></input>
          <div class="espace"></div>
          <input type="submit" name="submit" value="Confirmer"></input>
        </form>

    <?php
      } else {
        header('location:edit.php');
      }
    ?>
  </div>

<?php
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $pseudo = $_POST['email'];
    $pw = $_POST['pass'];

    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:editinline.php';
    $user1 = $obj1->update($id, $pseudo, $pw);
    echo $user1;
  }
?>

<?php include('inc/footer.php'); ?>
