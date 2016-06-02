<?php
  $pageTitle = 'Guide rapide';
  include 'inc/header.php';
?>
<link rel="stylesheet" type="text/css" href="css/clear.css">

    <div class="guide-box">

      <h2>Guide rapide</h2>

      <h6 style="text-align: center;">Découvrez la facilité de la gestion de tâches</h6>

      <p id="sub-guide-box">
        Bienvenue ! Cette guide est une brève introduction pour le gestionnaire de tâches To Do Lister.
        Êtes-vous prêt(e) à devenir plus organisé(é) et productif(ve) ? Let's go !
      </p>

      <h6 class="accordion"><i class="fa fa-user purple" aria-hidden="true"></i>&nbsp;&nbsp;Inscrivez-vous</h6>
      <div class="panel"><p>
        Commençons pour le commencement ! Vous devez vous <a href="inscription.php">inscrire</a> à To Do Lister.
        Allez à la page d'inscription pour créez votre compte gratuit... C'est fait ? On continue !
      </p></div>

      <h6 class="accordion"><i class="fa fa-plus-square blue" aria-hidden="true"></i>&nbsp;&nbsp;Ajouter des projets</h6>
      <div class="panel"><p>
        C'est très rapide et facile d'ajouter des projets à votre To Do Lister.
        Cliquez sur 'Ajouter un projet', ou tapez sur la touché entrée, après avoir saisi le titre de votre nouveau projet.
      </p>
      <div class="guide-projects">
        <img src="img/guide_add_project.png" alt="Ajouter un projet" />
      </div></div>

      <h6 class="accordion"><i class="fa fa-plus-square-o pink" aria-hidden="true"></i>&nbsp;&nbsp;Ajouter des tâches</h6>
      <div class="panel"><p>
        Une fois votre projet créé, cliquez sur son titre pour le sélectionner et faire apparaître la liste associée.
        Sur celle-ci, cliquez sur 'Ajouter une tâche' après avoir saisi le nom de la tâche.
      </p>
      <div class="guide-select">
        <img src="img/guide_select_project.png" alt="Sélectionner un projet" />
      </div>
      <div class="guide-items">
        <img src="img/guide_add_item.png" alt="Ajouter une tâche" />
      </div></div>

      <h6 class="accordion"><i class="fa fa-check-square-o green" aria-hidden="true"></i>&nbsp;&nbsp;Marquer une tâche comme complétée</h6>
      <div class="panel"><p>
        Cochez tout simplement la case à côté de la tâche et elle sera marquée comme complétée.
      </p><br/>
      <p>
        La même opération est disponible pour les projets. Attention, si un projet est marqué comme
        fait, toutes ses tâches le seront aussi.
      </p>
      <div class="guide-mark">
        <img src="img/guide_mark_item.png" alt="Marquer une tâche comme complétée" />
      </div></div>

      <h6 class="accordion"><i class="fa fa-times red" aria-hidden="true"></i>&nbsp;&nbsp;Supprimer une tâche</h6>
      <div class="panel"><p>
        Cliquez sur la croix rouge à droite du nom de la tâche. Attention, cette opération est irréversible.
      </p><br/>
      <p>
        La même opération est disponible pour les projets. Si un projet est supprimé, toutes ses tâches le seront
        aussi. Attention, cette opération est irréversible.
      </p>
      <div class="guide-delete">
        <img src="img/guide_delete_item.png" alt="Supprimer une tâche" />
      </div></div>

      <div class="center-arrow">
        <a href="#header" class="smoothScroll" id="arrow-up"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
      </div>

    </div>

<?php include('inc/footer.php'); ?>
