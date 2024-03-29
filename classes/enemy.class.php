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
    $this->magicValue = rand(1, 2);
    $this->luckValue = rand(1, 2);
  }

  // 選擇攻擊方式
  public function enemyChooseAttack($target)
  {
    $attackChosen = rand(1, 2);
    if ($attackChosen == "1") {
      self::launchPhysicalAttack($target);
    } else if ($attackChosen == "2") {
      self::launchMagicalAttack($target);
    } else {
      echo 'error!' . "\n";
    }
    sleep(1);
  }
}
