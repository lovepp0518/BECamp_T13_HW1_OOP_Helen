<?php

class Database
{
  public $connection;

  public function __construct()
  {
    // 引入.env中設定值
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $dsn = $_ENV['DB_DSN'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];

    try {
      $this->connection = new PDO($dsn, $username, $password);
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
