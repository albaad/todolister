<div class="self">
    <nav class="menu">
      <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" style="font-size:40px !important;" class="closebtn" onclick="closeNav()">×</a>
        <ul>
          <li><a <?php if ($pageId == 1) echo 'class="disabled"'; ?> href="admin.php">Liste utilisateurs</a></li>
          <li><a <?php if ($pageId == 2) echo 'class="disabled"'; ?> href="delete.php">Supprimer utilisateur</a></li>
          <li><a <?php if ($pageId == 3) echo 'class="disabled"'; ?> href="add.php">Ajouter utilisateur</a></li>
          <li><a <?php if ($pageId == 4) echo 'class="disabled"'; ?> href="edit.php">Modifier utilisateurs</a></li>
          <li><a href="../logout.php">Déconnexion</a></li>
        </ul>
      </div>
    </nav>

    <span style="margin-left: 15px;font-size:30px;cursor:pointer;color:#fff;" onclick="openNav()">☰</span>
</div>
