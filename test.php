<?php

include 'includes/autoloader.inc.php';

$start = microtime(true);

// 預測試程式碼
$pokemonNames = Enemy::generateEnemyNames();

$end = microtime(true);

// 印出執行時間
$executionTime = $end - $start;
echo "程式碼執行時間： $executionTime 秒";

// 印出$pokemonNames資料
var_dump($pokemonNames);