<?php
  $pageTitle = 'To Do Lister';

  include_once 'appmenu.php';
  include_once '../lib/ListerManager.php';

  unset($_SESSION['project_id']);
  unset($_SESSION['project_title']);

  $connect = ConnectionSingleton::getInstance('localhost', 'todolister', 'utf8', 'root', '');
	$db = $connect->dbconnect();
	$reader = new ListerManager($db);
	$_SESSION['location'] = "Location: index.php";
  $email = $_SESSION['email'];
  $projects = $reader->projectsList($email);
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
      <h1 class="header">Projects</h1>

      <?php if(!empty($projects)): ?>
      <ul class="items">
        <?php foreach($projects as $item): ?>
          <li>

            <?php if(!$item['done']) : ?>
              <a href="mark.php?pas=done&item=<?php echo $item['id']; ?>" class="done-button">
                <i class="fa fa-circle-o"></i>
              </a>
            <?php else :?>
              <a href="mark.php?pas=notdone&item=<?php echo $item['id']; ?>" class="notdone-button">
                <i class="fa fa-circle"></i>
              </a>
            <?php endif; ?>

            <span class="item<?php echo $item['done'] ? ' done' : '' ?>">
              <a href="index.php?project_id=<?php echo $item['id'];?>&title=<?php echo $item['title'];?>">
                <?php echo $item['title']; ?>
              </a>
            </span>

            <?php if($item['done']) : ?>
                <a href="javascript:delproject('<?php echo $item['id'];?>', '<?php echo $item['title'];?>')"class="del-button">
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
        <input type="text" name="title" placeholder="Type a new item here." class="input" autocomplete="off" required>
        <input type="submit" value="Add" class="submit-add">
      </form>

    </div>

    <script language="JavaScript" type="text/javascript">
    function delproject(id, title) {
      if (confirm("Vous êtes sûr de vouloir supprimer le projet '" + title + "' ?"))
          window.location.href = 'del.php?pas=del&item=' + id;
    }
    </script>

  </body>
</html>
