<?php

namespace App\Repository;


use App\Entity\Entity;

interface TableRepository
{
  public function findAll(): array;

  public function findById(int $id): ?Entity;
}