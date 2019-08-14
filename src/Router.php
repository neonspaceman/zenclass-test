<?php

namespace App;


class Router
{
  /**
   * @var Router
   */
  private static $instance = null;

  public static function getInstance(): self
  {
    if(!self::$instance)
      self::$instance = new self;
    return static::$instance;
  }

  private function __construct(){}

  protected $rules = [];

  public function set(string $rule, string $controller): self
  {
    $this->rules[$rule] = $controller;
    return $this;
  }

  public function resolve(): Response
  {
    // Prepare url
    $url = ltrim(urldecode($_SERVER['REQUEST_URI']), '/');
    $posQuery = mb_strpos($url, '?');
    if($posQuery !== false)
      $url = mb_substr($url, 0, $posQuery);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
      throw new \Exception('Unhandled request method. Only POST request method is supported.');
    }

    $controller = $this->rules[$url] ?? null;

    if (!$controller){
      throw new \Exception('Wrong api method');
    }

    $controller = explode('@', $controller);
    $controller[0] = '\\App\\Controller\\' . $controller[0];
    $controller[0] = new $controller[0]();

    return $controller[0]->{$controller[1]}();
  }
}