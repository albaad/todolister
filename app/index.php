<?php   $pageTitle = 'To Do Lister'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $pageTitle ?></title>

    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
  </head>
  <body>

<?php


  include 'appmenu.php';

  // Verifies user is logged in
  /*if(empty($_SESSION['email'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
      // User not logged in
      session_destroy();
      header("Location:../authentification.php");
    } else { // User logged in
    // Session variables for email
      $_SESSION['email'] = $_POST['email'];
    }
  }
  if($_SESSION['email'] == 'admin') {
    header("location: ../admin/admin.php");
  }*/


  require_once '../lib/ListerManager.php';

  $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
	$db = $connect->dbconnect();
	$reader = new ListerManager($db);
	$_SESSION['location'] = "Location: index.php";
  $items = $reader->readList($_SESSION['email']);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>To do lister</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/app-main.css">
    <link rel="stylesheet" href="../css/style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <div class="list">
      <h1 class="header">To do.</h1>

      <?php if(!empty($items)): ?>
      <ul class="items">
        <?php foreach($items as $item): ?>
          <li>
            <?php if(!$item['done']) : ?>
              <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">
                <i class="fa fa-circle-o"></i>
              </a>
              <!--<a href="mark.php?as=done&item=<?php //echo $item['id']; ?>" class="done-button">Mark as done</a>-->
            <?php else :?>
              <!--<a href="del.php?as=del&item=<?php //echo $item['id']; ?>" class="del-button">Delete</a>-->
              <a href="mark.php?as=notdone&item=<?php echo $item['id']; ?>" class="notdone-button">
                <i class="fa fa-circle"></i>
              </a>
              <!--<a href="mark.php?as=notdone&item=<?php echo $item['id']; ?>" class="notdone-button">Mask as not done</a>-->
            <?php endif; ?>

            <span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item['name']; ?></span>

            <?php if($item['done']) : ?>
              <!--<a href="del.php?as=del&item=<?php //echo $item['id']; ?>" class="del-button">Delete</a>-->
              <a href="del.php?as=del&item=<?php echo $item['id']; ?>" class="del-button">
                <i class="fa fa-remove"></i>
              </a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
        <p>You haven't added any items yet.</p>
      <?php endif; ?>

      <form class="item-add" action="add.php" method="post">
        <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
        <input type="submit" value="Add" class="submit-add">
      </form>

    </div>

  </body>
</html>
