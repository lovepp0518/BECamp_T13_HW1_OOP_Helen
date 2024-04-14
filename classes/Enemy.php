<?php

namespace Classes;

use Faker;

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

  // 透過套件faker新增10個不重複假名
  public static function generateEnemyNames()
  {
    require_once __DIR__ . '/../vendor/autoload.php';
    $faker = Faker\Factory::create();

    for ($i = 0; $i < 10; $i++) {
      $enemyNames[] = $faker->unique()->name();
    }

    return $enemyNames;
  }

  // 敵人選擇攻擊方式
  public function enemyChooseAttack($target)
  {
    echo '敵人發動攻擊！' . "\n";
    $attackChosen = rand(1, 2);
    if ($attackChosen == "1") {
      self::launchPhysicalAttack($target);
    } else if ($attackChosen == "2") {
      self::launchMagicalAttack($target);
    } else {
      echo '無效攻擊！' . "\n";
    }
    sleep(1);
  }
}
