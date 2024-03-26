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

  // Constructor
  public function __construct($name, $healthPoint, $physicalAttack, $magicalAttack, $physicalDefense, $magicalDefense, $magicValue, $luckValue)
  {
    $this->name = $name;
    $this->healthPoint = $healthPoint;
    $this->physicalAttack = $physicalAttack;
    $this->magicalAttack = $magicalAttack;
    $this->physicalDefense = $physicalDefense;
    $this->magicalDefense = $magicalDefense;
    $this->magicValue = $magicValue;
    $this->luckValue = $luckValue;
  }
  public function launchPhysicalAttack($target)
  {
    $target->healthPoint -= $this->physicalAttack;
    echo "{$this->name} 攻擊 {$target->name}. {$target->name} 減少血量 {$this->physicalAttack}，{$target->name} 目前血量 {$target->healthPoint}.\n";
  }
}
