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
}
