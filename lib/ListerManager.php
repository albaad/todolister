<?php
session_start();
include_once '../admin/lib/ConnectionSingleton.php';

class ListerManager {

  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function readList($project_id) {
    $project_id = NULL;
    /*$itemsQuery = $this->db->prepare("
      SELECT id, name, done FROM items
      WHERE project_id = :project_id'
    ");*/
    /*$itemsQuery->execute([
      'project_id' => $project_id
    ]);*/
    $itemsQuery = $this->db->prepare("
      SELECT id, name, done FROM items
    ");
    $itemsQuery->execute();
    $items = $itemsQuery->rowCount() ? $itemsQuery : [];
    return $items;
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

  public function mark($id, $as) {
    switch($as){
      case 'done' :
        $doneQuery = $this->db->prepare("
          UPDATE items
          SET done = 1
          WHERE id = :item
        ");
        $doneQuery->execute([
          'item' => $id,
        ]);
      break;
      case 'notdone' :
        $doneQuery = $this->db->prepare("
          UPDATE items
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

}
