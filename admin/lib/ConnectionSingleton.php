<?php
class ConnectionSingleton {

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
    if (is_null(self::$instance)) { // No PDO exists yet, so make one and send it back.
      self::$instance = new ConnectionSingleton($hote, $bd, $charset, $user, $password);
    }
    return self::$instance;
  }

  public function dbconnect(){
    try {
      $pdo = new PDO('mysql:host='.$this->hote.';dbname='.$this->bd.';charset='.$this->charset, $this->user, $this->password);
      return $pdo;
    } catch (PDOException $e) {
      die('<h1>Sorry. The Database connection is temporarily unavailable.</h1>');
    }
	}

}?>
