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

view::getMenu();

// 新增玩家角色
echo "新增玩家角色:\n";
$playerCareer = readline("Enter player's career(mage/warrior): ");
$playerName = readline("Enter player's name: ");
$playerHP = 20;
$playerPhysicalAttack = (int)readline("Enter player's physical attack: ");
$playerMagicalAttack = (int)readline("Enter player's magical attack: ");
$playerPhysicalDefense = (int)readline("Enter player's physical defense: ");
$playerMagicalDefense = (int)readline("Enter player's magical defense: ");
$playerMagicValue = (int)readline("Enter player's magic value: ");
$playerLuckValue = (int)readline("Enter player's luck value: ");

$player = new Player($playerCareer, $playerName, $playerHP, $playerPhysicalAttack, $playerMagicalAttack, $playerPhysicalDefense, $playerMagicalDefense, $playerMagicValue, $playerLuckValue);
echo '新增角色成功！' . "\n";
sleep(1);

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
sleep(1);

View::getGameLevel($enemy, $gameLevel);
sleep(1);

// 開始對戰
while ($player->healthPoint > 0 && $enemy->healthPoint > 0) {
  $player->launchPhysicalAttack($enemy);
  View::updateInfo($player, $enemy);
  sleep(1);
  if ($enemy->healthPoint <= 0) {
    View::getResult($gameLevel, $player);
    sleep(2);
    $player->gainExperienceValue($gameLevel);
    $player->calculatePlayerLevel();
    $player->healthPoint = 20; // 將玩家hp恢復(預設固定)
    $gameLevel++; //進入下一關
    $enemy = new Enemy($pokemonNames, $gameLevel);
    sleep(2);
    View::getGameLevel($enemy, $gameLevel);
    sleep(1);
  } else {
    $enemy->launchPhysicalAttack($player);
    View::updateInfo($player, $enemy);
    if ($player->healthPoint <= 0) {
      View::getResult($gameLevel, $enemy);
    }
  }
}
