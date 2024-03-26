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

class Character
{
  // Properties
  public $name;
  public $HP;
  public $physicalAttack;
  public $magicalAttack;
  public $physicalDefense;
  public $magicalDefense;
  public $magicValue;
  public $luckValue;

  // Constructor
  public function __construct($name, $HP, $physicalAttack, $magicalAttack, $physicalDefense, $magicalDefense, $magicValue, $luckValue)
  {
    $this->name = $name;
    $this->HP = $HP;
    $this->physicalAttack = $physicalAttack;
    $this->magicalAttack = $magicalAttack;
    $this->physicalDefense = $physicalDefense;
    $this->magicalDefense = $magicalDefense;
    $this->magicValue = $magicValue;
    $this->luckValue = $luckValue;
  }
  public function launchPhysicalAttack($target)
  {
    $target->HP -= $this->physicalAttack;
    echo "{$this->name} 攻擊 {$target->name}. {$target->name} 減少血量 {$this->physicalAttack}，{$target->name} 目前血量 {$target->HP}.\n";
  }
}


class Player extends Character
{
  // Properties
  public $career;
  public $playerLevel;
  public $experienceValue;

  // 設定職業
  public function setCareer($career)
  {
    $this->career = $career;
  }

  // 獲取經驗值
  public function gainExperienceValue($gameLevel)
  {
    if (
      $gameLevel % 5 === 0
    ) {
      $this->experienceValue += 200;
    } else {
      $this->experienceValue += 100;
    }
  }

  // 經驗值換算角色等級
  public function calculatePlayerLevel()
  {
    $playerLevelUpFactor = 300;
    $playerLevelUp = floor($this->experienceValue / $playerLevelUpFactor);
    if ($playerLevelUp >= 1) {
      $this->playerLevel += $playerLevelUp;
      $this->experienceValue -= $playerLevelUpFactor * $playerLevelUp;
      if ($this->career === 'mage') {
        $this->magicalAttack *= 2;
        $this->magicalDefense *= 2;
      } else if ($this->career === 'warrior') {
        $this->physicalAttack *= 2;
        $this->physicalDefense *= 2;
      } else {
        echo 'error! Please check your career';
      }
    }
  }
}

class Enemy extends Character
{
  // 生成下一關敵人
  public function generateNextEnemy(Enemy $baseline, $gameLevel)
  {
    $enemy = clone $baseline;
    $enemy->name = 'enemy' . $gameLevel;
    $enemy->HP = ($gameLevel + 1) * 10;
    $enemy->physicalAttack *= 1;
    $enemy->magicalAttack *= 1;
    $enemy->physicalDefense *= 1;
    $enemy->magicalDefense *= 1;
    $enemy->magicValue *= 1;
    return $enemy;
  }
}

class View
{
  // 清空螢幕畫面
  public static function clearScreen()
  {
    echo "\033[2J\033[H";
  }

  // 進入關卡
  public static function getGameLevel($gameLevel)
  {
    self::clearScreen();
    echo '進入第' . $gameLevel . '關' . "\n";
  }

  // 更新對戰資訊
  public static function updateInfo($player, $enemy)
  {
    self::clearScreen();
    printf("%-20s| %-20s\n", 'Player', 'Enemy');
    printf("%'-40s\n", '');
    printf("%-20s| %-20s\n", 'HP:' . $player->HP, 'HP:' . $enemy->HP);
  }

  // 取得對戰結果
  public static function getResult($gameLevel, $winner)
  {
    echo '第' . $gameLevel . '關挑戰結果：' . $winner->name . '勝利' . "\n";
  }
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
