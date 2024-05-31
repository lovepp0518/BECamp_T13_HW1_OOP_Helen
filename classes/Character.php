<?php

namespace Classes;

class Character
{
  public $name;
  public $healthPoint;
  public $physicalAttack;
  public $magicalAttack;
  public $physicalDefense;
  public $magicalDefense;
  public $magicValue;
  public $luckValue;
  private $criticalHitFactor;

  const DEFAULT_HEALTH_POINT = 100;
  const DEFAULT_ATTACK_DAMAGE_MULTIPLIER = 5;
  const DEFAULT_MAGIC_VALUE = 10;
  const DEFAULT_MAGIC_VALUE_CONSUMPTION = 2;
  const DEFAULT_MAGIC_VALUE_RESTORED = 1;

  private function isCriticalHit()
  {
    $this->criticalHitFactor = rand(1, 100);
    return $this->criticalHitFactor <= ($this->luckValue) * 10;
  }

  public function launchPhysicalAttack($target)
  {
    if (self::isCriticalHit()) {
      $target->healthPoint = $target->healthPoint - (($this->physicalAttack * self::DEFAULT_ATTACK_DAMAGE_MULTIPLIER) * 2 - $target->physicalDefense);
      echo "\n";
      echo '物理攻擊發動！產生爆擊傷害加倍！' . "\n";
    } else {
      $target->healthPoint = $target->healthPoint - (($this->physicalAttack * self::DEFAULT_ATTACK_DAMAGE_MULTIPLIER) - $target->physicalDefense);
      echo "\n";
      echo '物理攻擊發動！' . "\n";
    }
    sleep(1);
  }

  public function launchMagicalAttack($target)
  {
    if ($this->magicValue >= self::DEFAULT_MAGIC_VALUE_CONSUMPTION) {
      $target->healthPoint = $target->healthPoint - (($this->magicalAttack * self::DEFAULT_ATTACK_DAMAGE_MULTIPLIER) - $target->magicalDefense);
      $this->magicValue -= self::DEFAULT_MAGIC_VALUE_CONSUMPTION;
      echo "\n";
      echo '魔法攻擊發動！' . "\n";
    } else {
      echo '無效攻擊！魔力量不足無法發動魔法攻擊！' . "\n";
    }
    sleep(1);
  }

  public function restoreMagicValue()
  {
    if ($this->magicValue < self::DEFAULT_MAGIC_VALUE) {
      $this->magicValue += self::DEFAULT_MAGIC_VALUE_RESTORED;
    }
  }

  // 檢查角色是否活著
  public function isAlive()
  {
    return $this->healthPoint > 0;
  }
}
