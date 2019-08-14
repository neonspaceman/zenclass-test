<?php

namespace App\Controller;


use App\Config;
use App\Database;
use App\Repository\TableRepository;
use App\Response;
use App\Data;

class TableController
{
  /**
   * @var Database
   */
  protected $db;

  /**
   * @var array
   */
  protected $allowedTables;

  public function __construct()
  {
    $this->allowedTables = Config::getInstance()['allowed_tables'];
    $this->db = Database::getInstance();
  }

  public function index(): Response
  {
    $table = Data::post('table', 's');

    if (!in_array($table, $this->allowedTables)){
      throw new \Exception('This table is not allowed for viewing');
    }

    $id = Data::post('id', 'u');

    $repository = '\\App\\Repository\\' . $table . 'Repository';
    /** @var TableRepository $repository */
    $repository = new $repository();

    $data = $id
      ? $repository->findById($id)
      : $repository->findAll()
    ;

    return (new Response())->setPayload($data);
  }
}