<?php

class Player extends Character
{
  // Properties
  public $career;
  public $playerLevel;
  public $experienceValue;

  // Constructor
  public function __construct()
  {
    $this->career = readline("Enter player's career(mage/warrior): ");
    $this->name = readline("Enter player's name: ");
    $this->healthPoint = 100;
    $this->physicalAttack = (int)readline("Enter player's physical attack: ");
    $this->magicalAttack = (int)readline("Enter player's magical attack: ");
    $this->physicalDefense = (int)readline("Enter player's physical defense: ");
    $this->magicalDefense = (int)readline("Enter player's magical defense: ");
    $this->magicValue = 10;
    $this->luckValue = (int)readline("Enter player's luck value(1-5): ");
    $this->playerLevel = 1;
    $this->experienceValue = 0;
  }

  // 選擇攻擊方式
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
      echo '無效攻擊！選擇攻擊方式無效！' . "\n";
      sleep(1);
    }
  }

  // 獲取經驗值
  public function gainExperienceValue($gameLevel)
  {
    if (
      $gameLevel % 5 === 0
    ) {
      $this->experienceValue += 200;
    } else {
      $this->experienceValue += 100;
    }
  }

  // 經驗值換算角色等級
  public function calculatePlayerLevel()
  {
    $playerLevelUpFactor = 300;
    $playerLevelUp = floor($this->experienceValue / $playerLevelUpFactor);
    if ($playerLevelUp >= 1) {
      $this->playerLevel += $playerLevelUp;
      $this->experienceValue -= $playerLevelUpFactor * $playerLevelUp;
      if ($this->career === 'mage') {
        $this->magicalAttack *= 2;
        $this->magicalDefense *= 2;
      } else if ($this->career === 'warrior') {
        $this->physicalAttack *= 2;
        $this->physicalDefense *= 2;
      } else {
        echo 'error! Please check your career';
      }
    }
  }
}
