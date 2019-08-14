<?php

namespace App\Repository;


use App\Database;
use App\Entity\Participant;

class ParticipantRepository
{
  /**
   * @var Database
   */
  protected $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function findById(int $id): Participant
  {
    $q = 'SELECT `ID`, `Email`, `Name` FROM `Participant` WHERE `ID` = ?';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $id ]);
    $row = $stmt->fetch();

    if (!$row){
      throw new \Exception('There is no participant with such id');
    }

    return new Participant($row);
  }

  public function findByEmail(string $email): Participant
  {
    $q = 'SELECT `ID`, `Email`, `Name` FROM `Participant` WHERE `Email` = ?';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $email ]);
    $row = $stmt->fetch();

    if (!$row){
      throw new \Exception('There is no participant with such email');
    }

    return new Participant($row);
  }
}