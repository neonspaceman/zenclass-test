<?php

namespace App\Entity;


abstract class Entity
{
  public function __construct(array $data = [])
  {
    foreach($data as $name => $value) {
      $this->{$name} = $value;
    }
  }

  public function __call($method, $arguments)
  {
    $action = substr($method, 0, 3);
    $property = substr($method, 3);

    switch ($action) {
      case 'get':
        return $this->{$property} ?? null;

      case 'set':
        $this->{$property} = $arguments[0];
        return $this;
    }
    return null;
  }
}