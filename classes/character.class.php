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
    $criticalHitFactor = rand(1, 100);
    if (($this->luckValue === 1 && $criticalHitFactor <= 10) ||  ($this->luckValue === 2 && $criticalHitFactor <= 20) || ($this->luckValue === 3 && $criticalHitFactor <= 30) || ($this->luckValue === 4 && $criticalHitFactor <= 40) || ($this->luckValue === 5 && $criticalHitFactor <= 50)) {
      $target->healthPoint -= ($this->physicalAttack) * 2;
      echo "\n";
      echo '物理攻擊發動！產生爆擊傷害加倍！' . "\n";
      echo "{$this->name} 攻擊 {$target->name}. {$target->name} 減少血量 {$this->physicalAttack}*2，{$target->name} 目前血量 {$target->healthPoint}.\n";
    } else {
      $target->healthPoint -= $this->physicalAttack;
      echo "\n";
      echo '物理攻擊發動！' . "\n";
      echo "{$this->name} 攻擊 {$target->name}. {$target->name} 減少血量 {$this->physicalAttack}，{$target->name} 目前血量 {$target->healthPoint}.\n";
    }
    sleep(1);
  }

  public function launchMagicalAttack($target)
  {
    // 若本身魔力量大於最小魔力消耗值(先固定為一次魔力攻擊消耗2點魔力)
    if ($this->magicValue >= 2) {
      $target->healthPoint -= $this->magicalAttack;
      $this->magicValue -= 2;
      echo "\n";
      echo '魔法攻擊發動！' . "\n";
      echo "{$this->name} 攻擊 {$target->name}. {$target->name} 減少血量 {$this->magicalAttack}，{$target->name} 目前血量 {$target->healthPoint}.\n";
    } else {
      echo '無效攻擊！魔力量不足無法發動魔法攻擊！' . "\n";
    }
    sleep(1);
  }

  public function restoreMagicValue()
  {
    // 先假設魔力最大值是10點，每回合恢復1點
    if ($this->magicValue < 10) {
      $this->magicValue += 1;
    }
  }
}
