<div class="error">
  <?php
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
  ?>
</div>
<div class="success">
  <?php
    if(isset($_SESSION['confirmation'])) {
      echo $_SESSION['confirmation'];
      unset($_SESSION['confirmation']);
    }
  ?>
</div>
