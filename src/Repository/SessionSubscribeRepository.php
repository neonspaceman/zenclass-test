<?php

namespace App\Repository;


use App\Database;
use App\Entity\Participant;
use App\Entity\Session;

class SessionSubscribeRepository
{
  /**
   * @var Database
   */
  protected $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function subscribe(Session $session, Participant $participant)
  {
    $this->db->beginTransaction();

    $q = 'SELECT `SubscribersCount` FROM `Session` WHERE `ID` = ? LIMIT 1 FOR UPDATE';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $session->getID() ]);
    $subscribersCount = $stmt->fetchColumn();

    if ($subscribersCount >= $session->getCountLimit()){
      throw new \Exception('Session limit has been reached');
    }

    $q = 'SELECT COUNT(*) FROM `ParticipantSession` WHERE `ParticipantId` = ? LIMIT 1';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $participant->getID() ]);
    $isSubscribed = $stmt->fetchColumn();

    if ($isSubscribed){
      throw new \Exception('The user with such email has already been subscribed');
    }

    $q = 'INSERT INTO `ParticipantSession` (`ParticipantId`, `SessionId`) VALUES (?, ?)';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $participant->getID(), $session->getID() ]);

    $q = 'UPDATE `Session` SET `SubscribersCount` = `SubscribersCount` + 1 WHERE `ID` = ? LIMIT 1';
    $stmt = $this->db->prepare($q);
    $stmt->execute([ $session->getID() ]);

    $this->db->commit();
  }
}