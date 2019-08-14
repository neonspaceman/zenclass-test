<?php

namespace App\Repository;


use App\Database;
use App\Entity\Session;

class SessionRepository
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
   * @return Session[]
   */
  public function findAll(): array
  {
    $res = [];

    $q = 'SELECT `ID`, `Name`, `TimeOfEvent`, `Description`, `SubscribersCount`, `CountLimit` FROM `Session`';
    $stmt = $this->db->query($q);
    $stmt->execute();
    while($row = $stmt->fetch()){
      $res[] = new Session($row);
    }

    return $res;
  }

  public function findById(int $id): Session
  {
    $q = 'SELECT `ID`, `Name`, `TimeOfEvent`, `Description`, `SubscribersCount`, `CountLimit` FROM `Session` WHERE `ID` = ?';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $id ]);
    $row = $stmt->fetch();

    if (!$row){
      throw new \Exception('There is no session with such id');
    }

    return new Session($row);
  }
}