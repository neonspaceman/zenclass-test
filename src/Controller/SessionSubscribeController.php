<?php

namespace App\Controller;


use App\Data;
use App\Repository\ParticipantRepository;
use App\Repository\SessionRepository;
use App\Repository\SessionSubscribeRepository;
use App\Response;

class SessionSubscribeController
{
  /**
   * @var SessionSubscribeRepository
   */
  protected $sessionSubscribeRepository;

  /**
   * @var SessionRepository
   */
  protected $sessionRepository;

  /**
   * @var ParticipantRepository
   */
  protected $participantRepository;

  public function __construct()
  {
    $this->sessionSubscribeRepository = new SessionSubscribeRepository();
    $this->sessionRepository = new SessionRepository();
    $this->participantRepository = new ParticipantRepository();
  }

  public function index(): Response
  {
    $sessionId = Data::post('sessionId', 'u');
    $userEmail = Data::post('userEmail', 's');

    $session = $this->sessionRepository->findById($sessionId);
    $user = $this->participantRepository->findByEmail($userEmail);

    $this->sessionSubscribeRepository->subscribe($session, $user);

    return (new Response())
      ->setMessage('The user has been subscribed successfully');
  }
}