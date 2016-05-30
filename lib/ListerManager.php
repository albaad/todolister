<?php
session_start();
//include_once '../admin/lib/ConnectionSingleton.php';
include_once '../admin/lib/Connection.php';
//include_once '../lib/UserManager.php';

class ListerManager {

  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function readList($project_id) {
    $itemsQuery = $this->db->prepare("
      SELECT id, name, done, created, completed FROM items
      WHERE project_id = :project_id
    ");
    $itemsQuery->execute([
      'project_id' => $project_id
    ]);
    $items = $itemsQuery->rowCount() ? $itemsQuery : [];
    return $items;
  }

  public function projectsList($email) {
    $bdd = $this->db;
    $query = $this->db->prepare("
      SELECT projects.id, title, color, done, created FROM projects
      INNER JOIN users ON users.id = projects.user_id
      WHERE users.email = :email
    ");
    $query->execute([
      'email' => $email
    ]);
    $projects = $query->rowCount() ? $query : [];
    return $projects;
  }

  public function add($name, $project_id) {
    if(!empty($name)) {
      $addedQuery = $this->db->prepare("
        INSERT INTO items (name, project_id, done, created)
        VALUES (:name, :project_id, 0, NOW())
      ");
      $addedQuery->execute([
        'name' => $name,
        'project_id' => $project_id
      ]);
    }
    header($_SESSION['location']);
  }

  public function addProject($title, $email) {
    if(!empty($title)) {
      // Get user_id from $email
      $req = $this->db->prepare("SELECT id FROM users WHERE email=:email");
      $req->execute(['email' => $email]);
      $donnees = $req->fetch();
      $user_id = $donnees['id'];
      // Insert project
      $addQuery = $this->db->prepare("
        INSERT INTO projects (title, color, done, created, user_id)
        VALUES (:title, NULL, 0, NOW(), :user_id)
      ");
      $addQuery->execute([
        'title' => $title,
        'user_id' => $user_id
      ]);
    }
    header($_SESSION['location']);
  }

  public function mark($id, $as) {
    switch($as){
      case 'done' :
        $doneQuery = $this->db->prepare("
          UPDATE items
          SET done = 1, completed = NOW()
          WHERE id = :item
        ");
        $doneQuery->execute([
          'item' => $id,
        ]);
      break;
      case 'notdone' :
        $doneQuery = $this->db->prepare("
          UPDATE items
          SET done = 0, completed = :completed
          WHERE id = :item
        ");
        $doneQuery->execute([
          'item' => $id,
          'completed' => NULL
        ]);
      break;
    }
      header($_SESSION['location']);
  }

  public function markProject($id, $pas) {
    switch($pas){
      case 'done' :
        // Mark project as done
        $doneQuery = $this->db->prepare("
          UPDATE projects
          SET done = 1
          WHERE id = :item
        ");
        $doneQuery->execute([
          'item' => $id,
        ]);
        // Cascade: mark all project items as done
        $itemsDone = $this->db->prepare("
          UPDATE items
          SET done = 1, completed = NOW()
          WHERE project_id = :project_id
        ");
        $itemsDone->execute([
          'project_id' => $id,
        ]);
      break;
      case 'notdone' :
        // Mark project as not done
        $doneQuery = $this->db->prepare("
          UPDATE projects
          SET done = 0
          WHERE id = :item
        ");
        $doneQuery->execute([
          'item' => $id,
        ]);
      break;
    }
      header($_SESSION['location']);
  }

  public function del($id, $as) {
  	switch($as) {
  		case 'del':
  			$delQuery = $this->db->prepare("
  				DELETE FROM items
  				WHERE id = :item
  			");
  			$delQuery->execute([
  				'item' => $id
  			]);
  		break;
  	}
    header($_SESSION['location']);
  }

  public function delProject($id, $pas) {
    switch($pas) {
      case 'del':
        $delQuery = $this->db->prepare("
          DELETE FROM projects
          WHERE id = :item
        ");
        $delQuery->execute([
          'item' => $id
        ]);
      break;
    }
    header($_SESSION['location']);
  }

}
