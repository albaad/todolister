<?php
include 'lib/AdminManager.php';

$pageTitle = 'Modifier utilisateur';
include 'inc/header.php';
$pageId = 4;
include 'inc/menu.php';
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
    $pseudo = $_POST['email'];
    $pw = $_POST['pass'];
    $conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $bdd = $conect->dbconnect();
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:edit.php';
    $user1 = $obj1->update($id, $pseudo, $pw);
    echo $user1;
  }
?>

<?php include('inc/footer.php'); ?>
