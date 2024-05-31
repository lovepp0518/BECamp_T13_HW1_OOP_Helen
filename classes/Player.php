<?php

namespace Classes;

enum Career: string
{
  case Mage = 'mage';
  case Warrior = 'warrior';
}

class Player extends Character
{
  public Career $career;
  public $playerLevel;
  public $experienceValue;
  const EXPERIENCE_VALUE_GAIN_PER_GAME_LEVEL = 100;
  const EXPERIENCE_VALUE_REQUIRED_FOR_LEVEL_UP = 300;
  const BOSS_LEVEL_INTERVAL = 5;

  public function __construct()
  {
    $careerInput = readline("請輸入玩家職業(mage/warrior): ");
    if ($careerInput === 'mage') {
      $this->career = Career::Mage;
    } elseif ($careerInput === 'warrior') {
      $this->career = Career::Warrior;
    } else {
      throw new \InvalidArgumentException('無效的職業輸入');
    }

    $this->name = readline("請輸入玩家名稱: ");
    $this->healthPoint = self::DEFAULT_HEALTH_POINT;
    $this->physicalAttack = (int)readline("請輸入玩家物理攻擊力: ");
    $this->magicalAttack = (int)readline("請輸入玩家魔法攻擊力: ");
    $this->physicalDefense = (int)readline("請輸入玩家物理防禦力: ");
    $this->magicalDefense = (int)readline("請輸入玩家魔法防禦力: ");
    $this->magicValue = self::DEFAULT_MAGIC_VALUE;
    $this->luckValue = (int)readline("請輸入玩家幸運值(1-5): ");
    $this->playerLevel = 1;
    $this->experienceValue = 0;
  }

  // 玩家選擇攻擊方式
  public function playerChooseAttack($target)
  {
    echo "請選擇攻擊方式 (1)物理攻擊 (2)魔法攻擊\n";
    $attackChosen = readline("請輸入你的選項: ");
    echo "\n";
    echo '玩家發動攻擊！' . "\n";
    if ($attackChosen == "1") {
      self::launchPhysicalAttack($target);
    } else if ($attackChosen == "2") {
      self::launchMagicalAttack($target);
    } else {
      echo '無效攻擊！' . "\n";
      sleep(1);
    }
  }

  // 獲取經驗值
  public function gainExperienceValue($gameLevel)
  {
    if (
      $gameLevel % self::BOSS_LEVEL_INTERVAL === 0
    ) {
      $this->experienceValue += (self::EXPERIENCE_VALUE_GAIN_PER_GAME_LEVEL * 2);
    } else {
      $this->experienceValue += self::EXPERIENCE_VALUE_GAIN_PER_GAME_LEVEL;
    }
  }

  // 經驗值換算角色等級
  public function calculatePlayerLevel()
  {
    $playerLevelUp = floor($this->experienceValue / self::EXPERIENCE_VALUE_REQUIRED_FOR_LEVEL_UP);
    if ($playerLevelUp >= 1) {
      $this->playerLevel += $playerLevelUp;
      $this->experienceValue -= self::EXPERIENCE_VALUE_REQUIRED_FOR_LEVEL_UP * $playerLevelUp;
      if ($this->career === Career::Mage) {
        $this->magicalAttack *= 2;
        $this->magicalDefense *= 2;
      } else if ($this->career === Career::Warrior) {
        $this->physicalAttack *= 2;
        $this->physicalDefense *= 2;
      } else {
        echo '輸入職業無效';
      }
    }
  }

  public function restoreHealthPoint()
  {
    $this->healthPoint = self::DEFAULT_HEALTH_POINT;
  }
}
