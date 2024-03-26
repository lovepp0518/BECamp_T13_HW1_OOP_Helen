<?php

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