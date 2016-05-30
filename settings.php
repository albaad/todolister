<?php
  include 'inc/autorisation.php';
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
      <div class="espace"></div>
      <p><a class="action" style="color:red; font-size: 0.8em;" href="javascript:delaccount('<?php echo $_SESSION['email'];?>')">Supprimer compte</a></p>
    </div>

  <?php }
  else header('location:authentification.php');
  ?>

<?php
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $pseudo = $_POST['pseudo'];
    $pw = $_POST['pass'];

    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $obj1 = new AdminManager($bdd);
    $_SESSION['location'] = 'Location:modify.php';
    $user1 = $obj1->update($id, $pseudo, $pw);
    echo $user1;
  }
  if(isset($_GET['deletemail'])) {
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    $obj1 = new UserManager($bdd);
    $user1 = $obj1->delete($_GET['deletemail']);
    $_SESSION['error'] = "Votre compte a été supprimé.";
  }
?>

  </div>

  <script language="JavaScript" type="text/javascript">
  function delaccount(id) {
    if (confirm("Vous êtes sûr de vouloir supprimer votre compte ?"))
        window.location.href = 'settings.php?deletemail=' + id;
  }
  </script>

<?php include('inc/footer.php'); ?>
