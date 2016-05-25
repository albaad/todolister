<?php
  $pageTitle = 'To Do Lister';

  include_once 'appmenu.php';
  include_once '../lib/ListerManager.php';

  if (!isset($_SESSION['project_id'])) {
    if (isset($_GET['project_id'])) {
      $_SESSION['project_id'] = $_GET['project_id'];
      $_SESSION['project_title'] = $_GET['title'];
    } else {
      header('Location:index-pl.php');
    }
  }

  $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
  $db = $connect->dbconnect();
  $reader = new ListerManager($db);
  $_SESSION['location'] = "Location: index.php";
  $project_id = $_SESSION['project_id'];
  $items = $reader->readList($project_id);
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

      <h1 class="header"><?php echo $_SESSION['project_title']; ?></h1>

      <?php if(!empty($items)): ?>
      <ul class="items">
        <?php foreach($items as $item): ?>
          <li>
            <?php if(!$item['done']) : ?>
              <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">
                <i class="fa fa-circle-o"></i>
              </a>
            <?php else :?>
              <a href="mark.php?as=notdone&item=<?php echo $item['id']; ?>" class="notdone-button">
                <i class="fa fa-circle"></i>
              </a>
            <?php endif; ?>

            <span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item['name']; ?></span>

            <?php //if($item['done']) : ?>
              <a href="del.php?as=del&item=<?php echo $item['id']; ?>" class="del-button">
                <i class="fa fa-remove"></i>
              </a>
            <?php //endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
        <p>You haven't added any items yet.</p>
      <?php endif; ?>

      <form class="item-add" action="add.php?project_id=<?php echo $_SESSION['project_id']; ?>" method="post">
        <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
        <input type="submit" value="Add" class="submit-add">
      </form>

    </div>

  </body>
</html>
