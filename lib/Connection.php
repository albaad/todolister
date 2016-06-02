<?php
class Connection {

  static private $instance = null;

  private $hote;
  private $bd;
  private $charset;
  private $user;
  private $password;

  private function __construct($hote, $bd, $charset, $user, $password) {
    $this->hote = $hote;
    $this->bd = $bd;
    $this->charset = $charset;
    $this->user = $user;
    $this->password = $password;
  }

  public static function getInstance($hote, $bd, $charset, $user, $password) {
    if(is_null(self::$instance)) {
      self::$instance =  new PDO('mysql:host='.$hote.';dbname='.$bd.';charset='.$charset, $user, $password);
    }
    return self::$instance;
  }

}

?>
