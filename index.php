<?php

include 'includes/autoloader.inc.php';

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 資料庫連線
$dsn = $_ENV['DB_DSN'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

try {
  $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  echo "連線失敗: " . $e->getMessage() . "\n";
}

$player = new Player('player1', 20, 1, 1, 1, 1, 1, 1);
$player->setCareer('mage');
echo '新增角色成功！' . "\n";
sleep(1);

$enemy = new Enemy('enemy1', 12, 1, 1, 1, 1, 1, 1);
echo '敵人出現！' . "\n";
sleep(1);

$gameLevel = 1;
View::getGameLevel($gameLevel);
sleep(1);

// 開始對戰
while ($player->HP > 0 && $enemy->HP > 0 && $gameLevel > 0) {
  $player->launchPhysicalAttack($enemy);
  View::updateInfo($player, $enemy);
  sleep(1);
  if ($enemy->HP <= 0) {
    View::getResult($gameLevel, $player);
    sleep(2);
    $player->gainExperienceValue($gameLevel);
    $player->calculatePlayerLevel();
    $player->HP = 20; // 將玩家hp恢復(預設固定)
    $gameLevel++; //進入下一關
    $enemy = $enemy->generateNextEnemy($enemy, $gameLevel);
    View::getGameLevel($gameLevel);
    sleep(1);
  } else {
    $enemy->launchPhysicalAttack($player);
    View::updateInfo($player, $enemy);
    if ($player->HP <= 0) {
      View::getResult($gameLevel, $enemy);
      $gameLevel = 0; // 不再進入下一關
    }
  }
}
