<?php
	//session_start();
	//include 'inc/autorisation.php';
  //session_destroy();
  $pageTitle = 'Modifier mot de passe';
  include 'inc/header.php';

  include_once 'lib/UserManager.php';

  /*if(isset($_GET['email'])) {
    $conect = ConnectionSingleton::getInstance('localhost', 'nfa021', 'utf8', 'root', '');
    $bdd = $conect->dbconnect();
    $obj1 = new UserManager($bdd);
    $_SESSION['location'] = 'Location:admin.php';
  }*/

  //header("Location:modify.php");
?>

  <div class="login">
    <h4>Modifier mot de passe</h4>

    <div class="error">
      <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
      ?>
    </div>

    <form class="" action="modify.php" method="post">
      <input type="text" name="email" value="<?php echo $_SESSION['email'];?>" ></input>
      <input name='pw' placeholder='Nouveau mdp' type='password'></input>
      <input name='pw2' placeholder='Nouveau mdp (encore)' type='password'></input>
      <div class="espace"></div>
      <input type="submit" name="submit" value="Confirmer" class="animated"></input>
    </form>
  </div>

<?php
  if(isset($_POST['submit'])) {
    $pw = $_POST['pw'];
    $pw2 = $_POST['pw2'];
    $email = $_POST['email'];

    //$conect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
    //$bdd = $conect->dbconnect();
    $bdd = Connection::getInstance('localhost', 'todolister', 'utf8', 'root', '');

    $obj1 = new UserManager($bdd);
    $_SESSION['location'] = 'Location:modify.php';
    $user1 = $obj1->update($email, $pw, $pw2);
    echo $user1;
  }
?>

<?php include('inc/footer.php'); ?>
