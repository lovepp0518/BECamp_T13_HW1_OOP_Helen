<?php

// 資料庫連線
$dsn = "mysql:host=localhost;port=3306;dbname=book;charset=utf8mb4";
$username = "root";
$password = "password";

try {
  $pdo = new PDO($dsn, $username, $password);
  $statement = $pdo->prepare("SELECT * FROM Books LIMIT 10");
  $statement->execute();
  $posts = $statement->fetchAll();
  var_dump($posts);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
