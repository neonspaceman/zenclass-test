<?php

require_once __DIR__ . '/bootstrap.php';

const API_PREFIX = 'api/';

$router = \App\Router::getInstance();
$router->set(API_PREFIX . 'Table', 'TableController@index');
$router->set(API_PREFIX . 'SessionSubscribe', 'SessionSubscribeController@index');

try {
  $response = $router->resolve();
  $response->send();
} catch (Exception $e) {
  $response = new \App\Response();
  $response
    ->setStatus('error')
    ->setMessage($e->getMessage())
    ->send()
  ;
}

echo PHP_EOL;