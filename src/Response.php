<?php

namespace App;

class Response
{
  /**
   * @var string
   */
  private $status = 'ok';

  /**
   * @var mixed
   */
  private $payload = [];

  /**
   * @var string
   */
  private $message = '';

  public function __construct(){}

  public function getStatus(): string
  {
    return $this->status;
  }

  public function setStatus(string $status): self
  {
    $this->status = $status;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getPayload()
  {
    return $this->payload;
  }

  /**
   * @param mixed $payload
   * @return Response
   */
  public function setPayload($payload): self
  {
    $this->payload = $payload;
    return $this;
  }

  public function getMessage(): string
  {
    return $this->message;
  }

  public function setMessage(string $message): self
  {
    $this->message = $message;
    return $this;
  }

  public function send()
  {
    echo json_encode([
      'status' => $this->status,
      'payload' => $this->payload,
      'message' => $this->message,
    ]);
  }
}