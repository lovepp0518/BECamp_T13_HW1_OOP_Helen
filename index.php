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

$gameLevel = 1;

// 藉由pokeAPI預生成10個不重複敵人名稱(預設僅有10個關卡)
// 產生不重複隨機整數
function generateUniqueRandomNumbers($min, $max, $count)
{
  $randomNumbers = [];

  while (count($randomNumbers) < $count) {
    $randomNumber = rand($min, $max);
    if (!in_array($randomNumber, $randomNumbers)) {
      $randomNumbers[] = $randomNumber;
    }
  }

  return $randomNumbers;
}

// 產生10個介於1到1000之間的隨機整數
$pokemonIds = generateUniqueRandomNumbers(1, 1000, 10);

// 串接pokeAPI
foreach ($pokemonIds as $pokemonId) {
  // API 端點 URL
  $url = "https://pokeapi.co/api/v2/pokemon/$pokemonId";

  // 向 API 發送 GET 請求並取得回應
  $response = file_get_contents($url);

  // 如果回應為 JSON 格式，可以使用 json_decode 函式將其轉換為 PHP 陣列或物件
  $data = json_decode($response, true); // 第二個參數為 true 表示將 JSON 解析為關聯陣列

  $pokemonNames[] = $data['name'];
}

$enemy = new Enemy($pokemonNames, $gameLevel);

View::getGameLevel($enemy, $gameLevel);

$startTime = date("Y-m-d H:i:s");

// 開始對戰
while ($player->healthPoint > 0 && $enemy->healthPoint > 0) {
  View::updateInfo($player, $enemy, $gameLevel);

  // 玩家開始攻擊
  $player->playerChooseAttack($enemy);
  View::updateInfo($player, $enemy, $gameLevel);
  $player->restoreMagicValue();

  if ($enemy->healthPoint <= 0) {
    View::getResult($gameLevel, $player);
    $player->gainExperienceValue($gameLevel);
    $player->calculatePlayerLevel();
    if ($gameLevel === 10) {
      view::announcePlayerVictory();
      $endTime = date("Y-m-d H:i:s");
      $gameLevelPassed = $gameLevel;
      $recordData = [$player->name, $gameLevelPassed, $startTime, $endTime];
    } else {
      $player->healthPoint = 100; // 將玩家hp恢復(預設固定)
      $gameLevel++; //進入下一關
      $enemy = new Enemy($pokemonNames, $gameLevel);
      View::getGameLevel($enemy, $gameLevel);
    }

    // 敵人開始攻擊
  } else {
    $enemy->enemyChooseAttack($player);
    View::updateInfo($player, $enemy, $gameLevel);
    $enemy->restoreMagicValue();

    if ($player->healthPoint <= 0) {
      View::getResult($gameLevel, $enemy);
      $endTime = date("Y-m-d H:i:s");
      $gameLevelPassed = $gameLevel - 1;
      $recordData = [$player->name, $gameLevelPassed, $startTime, $endTime];
    }
  }
}

// 在資料庫中新增遊戲記錄資料
$db->insert("INSERT INTO records (player_name, level_passed, start_time, end_time) VALUES (?, ?, ?, ?)", $recordData);
