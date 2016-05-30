<?php
include 'inc/autorisation.php';

$pageTitle = 'To Do Lister';
include 'inc/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/clear.css">
<link rel="stylesheet" type="text/css" href="css/home.css">

  <div class="index">

    <h2>To Do Lister</h2>


    <div id="widgets">
        <ul class="todolister">

        <li id="title">
          <img src="img/todolister-title.png" alt="" />
        </li>
        <li id="guide">
          <a href="guide.php" class="img-guide"></a>
        </li>
        <li id="login">
          <a href="authentification.php" class="img-login"></a>
        </li>
        <li id="register">
          <a href="inscription.php" class="img-register"></a>
        </li>
        <li id="contact">
          <a href="contact.php" class="img-contact"></a>
        </li>
      </ul>
    </div>

  </div>


  <style media="screen">
  /* To Do Lister - image-home links */
  ul.todolister  {
    display: none;
    list-style-type: none;
  }

  ul.todolister li {
    margin-bottom: 10px;
  }

  ul.todolister li a {
    width: 400px;
    height: 43px;
    display: inline-block;
  }

  #title {
    margin-bottom: 20px;
  }
  .img-guide {
    background: url('../img/todolister-guide.png') center top no-repeat;
  }
  .img-guide:hover {
    background: url('../img/todolister-guide-hover.png') center top no-repeat;
  }
  .img-login {
    background: url('../img/todolister-login.png') center top no-repeat;
  }
  .img-login:hover {
    background: url('../img/todolister-login-hover.png') center top no-repeat;
  }
  .img-register {
    background: url('../img/todolister-register.png') center top no-repeat;
  }
  .img-register:hover {
    background: url('../img/todolister-register-hover.png') center top no-repeat;
  }
  .img-contact {
    background: url('../img/todolister-contact.png') center top no-repeat;
  }
  .img-contact:hover {
    background: url('../img/todolister-contact-hover.png') center top no-repeat;
  }
  </style>


<?php include('inc/footer.php'); ?>
