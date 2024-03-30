<?php

class Player extends Character
{
  // Properties
  public $career;
  public $playerLevel;
  public $experienceValue;

  // Constructor
  public function __construct($career, $name, $healthPoint, $physicalAttack, $magicalAttack, $physicalDefense, $magicalDefense, $luckValue)
  {
    $this->career = $career;
    $this->name = $name;
    $this->healthPoint = $healthPoint;
    $this->physicalAttack = $physicalAttack;
    $this->magicalAttack = $magicalAttack;
    $this->physicalDefense = $physicalDefense;
    $this->magicalDefense = $magicalDefense;
    $this->luckValue = $luckValue;
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
