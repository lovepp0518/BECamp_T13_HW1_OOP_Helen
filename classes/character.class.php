<?php

class Character
{
  // Properties
  public $name;
  public $healthPoint;
  public $physicalAttack;
  public $magicalAttack;
  public $physicalDefense;
  public $magicalDefense;
  public $magicValue;
  public $luckValue;

  public function launchPhysicalAttack($target)
  {
    $target->healthPoint -= $this->physicalAttack;
    echo "{$this->name} 攻擊 {$target->name}. {$target->name} 減少血量 {$this->physicalAttack}，{$target->name} 目前血量 {$target->healthPoint}.\n";
  }
}
