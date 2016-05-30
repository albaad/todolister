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

    <div class="erreur">
      <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
      ?>
    </div>

    <?php
      if(isset($_GET['id'])) {
        //$conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
        //$bdd = $conect->dbconnect();
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
    //$conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    //$bdd = $conect->dbconnect();
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:editinline.php';
    $user1 = $obj1->update($id, $pseudo, $pw);
    echo $user1;
  }
?>

<?php include('inc/footer.php'); ?>
