<?php
  //include_once 'inc/adminrights.php';
  include 'lib/AdminManager.php';

  $pageTitle = 'ADMIN - Liste utilisateurs';
  include 'inc/header.php';
  $pageId = 1;
  include 'inc/menu.php';
?>

  <div class="login">
    <h3>Liste utilisateurs</h3>
  </div>

<?php
  $conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $bdd = $conect->dbconnect();
  $obj1 = new AdminManager($bdd);
  $users = $obj1->getAll();
?>

  <div class="tab-liste">
    <table id="liste">
      <tr>
        <th>Action</th>
        <th>id</th>
        <th>email</th>
        <th>mdp</th>
      </tr>
      <?php while($donnees = $users->fetch()) {?>
        <tr>
            <td id="modsup">
              <a class="action" href="editinline.php?id=<?php echo $donnees['id'];?>">Modifier</a> |
              <a class="action" href="javascript:deluser('<?php echo $donnees['id'];?>')">Supprimer</a>
            </td>
            <td><?php echo $donnees["id"];?></td>
            <td><?php echo $donnees["email"];?></td>
            <td><?php echo $donnees["pw"];?></td>
          </tr>
      <?php } ?>
    </table>
    <div class="espace"></div>
    <a id='addLink' href="add.php">Ajouter utilisateur</a>
  </div>

  <script language="JavaScript" type="text/javascript">
  function deluser(id) {
    if (confirm("Vous êtes sûr de vouloir supprimer l'utilisateur '" + id + "' ?"))
        window.location.href = 'delete.php?deleteid=' + id;
  }
  </script>

<?php $users->closeCursor(); // Closes query treatment ?>

<?php include('inc/footer.php'); ?>
