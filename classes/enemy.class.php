<?php

class Enemy extends Character
{
  public function __construct($pokemonNames, $gameLevel)
  {
    $this->name = $pokemonNames[($gameLevel - 1)];
    $this->healthPoint = 20;
    $this->physicalAttack = rand(1, 2);
    $this->magicalAttack = rand(1, 2);
    $this->physicalDefense = rand(1, 2);
    $this->magicalDefense = rand(1, 2);
    $this->magicValue = 10;
    $this->luckValue = rand(1, 2);
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
