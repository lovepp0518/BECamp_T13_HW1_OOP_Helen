<?php

// 資料庫連線
$dsn = "mysql:host=localhost;port=3306;dbname=book;charset=utf8mb4";
$username = "root";
$password = "password";

try {
  $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  echo "連線失敗: " . $e->getMessage() . "\n";
}
