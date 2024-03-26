<?php

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