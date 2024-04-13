<?php

namespace Classes;

use Dotenv;
use PDO;
use PDOException;

class Database
{
  public $connection;

  public function __construct()
  {
    // 引入.env中設定值
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $dataSourceName = $_ENV['DATABASE_DATA_SOURCE_NAME'];
    $username = $_ENV['DATABASE_USERNAME'];
    $password = $_ENV['DATABASE_PASSWORD'];

    try {
      $this->connection = new PDO($dataSourceName, $username, $password);
      echo '[資料庫提示訊息]連線成功！' . "\n";
      sleep(1);
    } catch (PDOException $e) {
      echo '[資料庫提示訊息]連線失敗: ' . $e->getMessage() . "\n";
      sleep(1);
    }
  }

  public function query($query)
  {
    $statement = $this->connection->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($insert, $data)
  {
    $statement = $this->connection->prepare($insert);
    $statement->execute($data);
  }
}
