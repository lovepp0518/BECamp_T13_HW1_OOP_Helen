<?php

require 'vendor/autoload.php';

use Classes\Database;
use Classes\Enemy;
use Classes\Player;
use Classes\Record;
use Classes\View;

// 取得全部遊戲紀錄
$dataBase = new Database();
$recordsInDB = $dataBase->query("SELECT * FROM records");

// 進入主選單畫面
View::getMenu($recordsInDB);

// 新增玩家角色
View::addPlayerCharacter();
$player = new Player();

// 生成遊戲記錄和敵人並進入關卡
$record = new Record($player->name);
$enemyNames = Enemy::generateEnemyNames();
$enemy = new Enemy($enemyNames, $record->gameLevel);
View::getGameLevel($enemy, $record->gameLevel);

// 開始對戰
while ($player->isAlive() && $enemy->isAlive()) {
  View::updateInfo($player, $enemy, $record->gameLevel);

  // 玩家開始攻擊
  $player->playerChooseAttack($enemy);
  View::updateInfo($player, $enemy, $record->gameLevel);
  $player->restoreMagicValue();

  if (!$enemy->isAlive()) {
    View::getResult($record->gameLevel, $player);
    $player->gainExperienceValue($record->gameLevel);
    $player->calculatePlayerLevel();

    // 假設遊戲共10關，玩家連贏10關為闖關成功
    if ($record->gameLevel === 10) {
      View::announcePlayerVictory();
      $record->getRecord($enemy);
    } else {
      $player->restoreHealthPoint();
      $record->getNextGameLevel();
      $enemy = new Enemy($enemyNames, $record->gameLevel);
      View::getGameLevel($enemy, $record->gameLevel);
    }

    // 敵人開始攻擊
  } else {
    $enemy->enemyChooseAttack($player);
    View::updateInfo($player, $enemy, $record->gameLevel);
    $enemy->restoreMagicValue();

    if (!$player->isAlive()) {
      View::getResult($record->gameLevel, $enemy);
      $record->getRecord($enemy);
    }
  }
}

// 在資料庫中新增遊戲記錄資料
$dataBase->insert("INSERT INTO records (player_name, level_passed, start_time, end_time) VALUES (?, ?, ?, ?)", [$record->playerName, $record->gameLevelPassed, $record->startTime, $record->endTime]);
