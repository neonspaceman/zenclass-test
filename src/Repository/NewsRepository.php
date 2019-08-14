<?php

namespace App\Repository;


use App\Database;
use App\Entity\Entity;
use App\Entity\News;

class NewsRepository implements TableRepository
{
  /**
   * @var Database
   */
  protected $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  /**
   * @return News[]
   */
  public function findAll(): array
  {
    $res = [];

    $q = 'SELECT `ID`, `ParticipantId`, `NewsTitle`, `NewsMessage`, `LikesCounter` FROM `News`';
    $stmt = $this->db->query($q);
    $stmt->execute();
    while($row = $stmt->fetch()){
      $res[] = new News($row);
    }

    return $res;
  }

  public function findById(int $id): Entity
  {
    $q = 'SELECT `ID`, `ParticipantId`, `NewsTitle`, `NewsMessage`, `LikesCounter` FROM `News` WHERE `ID` = ?';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $id ]);
    $row = $stmt->fetch();

    if (!$row){
      throw new \Exception('There is no news with such id');
    }

    return new News($row);
  }
}