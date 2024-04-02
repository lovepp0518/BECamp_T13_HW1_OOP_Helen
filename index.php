<?php

include 'includes/autoloader.inc.php';

// 取得全部遊戲紀錄
$db = new Database();
$recordsInDB = $db->query("SELECT * FROM records");

view::getMenu($recordsInDB);

// 新增玩家角色
view::clearScreen();
echo '新增玩家角色:' . "\n";

$player = new Player();

view::clearScreen();
echo '遊戲敵人生成中，請稍候...' . "\n";

$record = new Record($player->name);

$pokemonNames = Enemy::generateEnemyNames();

$enemy = new Enemy($pokemonNames, $record->gameLevel);

View::getGameLevel($enemy, $record->gameLevel);

// 開始對戰
while ($player->healthPoint > 0 && $enemy->healthPoint > 0) {
  View::updateInfo($player, $enemy, $record->gameLevel);

  // 玩家開始攻擊
  $player->playerChooseAttack($enemy);
  View::updateInfo($player, $enemy, $record->gameLevel);
  $player->restoreMagicValue();

  if ($enemy->healthPoint <= 0) {
    View::getResult($record->gameLevel, $player);
    $player->gainExperienceValue($record->gameLevel);
    $player->calculatePlayerLevel();

    if ($record->gameLevel === 10) {
      view::announcePlayerVictory();
      $record->getRecord($enemy);
    } else {
      $player->healthPoint = 100; // 將玩家hp恢復(預設固定)
      $record->getNextGameLevel();
      $enemy = new Enemy($pokemonNames, $record->gameLevel);
      View::getGameLevel($enemy, $record->gameLevel);
    }

    // 敵人開始攻擊
  } else {
    $enemy->enemyChooseAttack($player);
    View::updateInfo($player, $enemy, $record->gameLevel);
    $enemy->restoreMagicValue();

    if ($player->healthPoint <= 0) {
      View::getResult($record->gameLevel, $enemy);
      $record->getRecord($enemy);
    }
  }
}

// 在資料庫中新增遊戲記錄資料
$db->insert("INSERT INTO records (player_name, level_passed, start_time, end_time) VALUES (?, ?, ?, ?)", [$record->playerName, $record->gameLevelPassed, $record->startTime, $record->endTime]);
