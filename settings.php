<?php
  //session_start();
  include 'inc/autorisation.php';
  //session_destroy();
  $pageTitle = 'Parametres';
  include 'inc/header.php';
?>

  <div class="login">
    <h2>Paramètres</h2>

    <div class="error">
      <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
      ?>
    </div>

    <?php if (isset($_SESSION['email'])){ ?>
    <div class="non-liste">
      <table id="params">
        <tr>
          <td class="paramstitle">E-mail : </td>
          <td><?php echo $_SESSION['email'];?></td>
        </tr>
        <tr>
          <td class="paramstitle">Mot de passe :</td>
          <td>******
            <span>
              <a class="action" href="modify.php?email=<?php echo $_SESSION['email'];?>">modifier</a>
            </span>
          </td>
        </tr>
      </table>
    </div>

  <?php }
  else header('location:authentification.php');
  ?>

<?php
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $pseudo = $_POST['pseudo'];
    $pw = $_POST['pass'];
    $conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $bdd = $conect->dbconnect();
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:modify.php';
    $user1 = $obj1->update($id, $pseudo, $pw);
    echo $user1;
  }
?>

  </div>

<?php include('inc/footer.php'); ?>
