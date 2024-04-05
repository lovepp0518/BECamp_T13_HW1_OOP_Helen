<?php

class Enemy extends Character
{
  public function __construct($enemyNames, $gameLevel)
  {
    $this->name = $enemyNames[($gameLevel - 1)];
    $this->healthPoint = self::DEFAULT_HEALTH_POINT;
    $this->physicalAttack = rand(1, 2);
    $this->magicalAttack = rand(1, 2);
    $this->physicalDefense = rand(1, 2);
    $this->magicalDefense = rand(1, 2);
    $this->magicValue = self::DEFAULT_MAGIC_VALUE;
    $this->luckValue = rand(1, 5);
  }

  // 藉由pokeAPI預生成10個不重複敵人名稱(預設僅有10個關卡)
  public static function generateEnemyNames()
  {
    $pokemonIds = [];

    while (count($pokemonIds) < 10) {
      $randomNumber = rand(1, 1025);
      if (!in_array($randomNumber, $pokemonIds)) {
        $pokemonIds[] = $randomNumber;
      }
    }

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

    return $pokemonNames;
  }

  // 選擇攻擊方式
  public function enemyChooseAttack($target)
  {
    echo '敵人發動攻擊！' . "\n";
    $attackChosen = rand(1, 2);
    if ($attackChosen == "1") {
      self::launchPhysicalAttack($target);
    } else if ($attackChosen == "2") {
      self::launchMagicalAttack($target);
    } else {
      echo '無效攻擊！選擇攻擊方式無效！' . "\n";
    }
    sleep(1);
  }
}
