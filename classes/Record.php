<?php

namespace Classes;

class Record
{
  public $playerName;
  public $gameLevel;
  public $gameLevelPassed;
  public $startTime;
  public $endTime;
  
  public function __construct($playerName)
  {
    $this->playerName = $playerName;
    $this->gameLevel = 1;
    $this->startTime = date("Y-m-d H:i:s");
  }

  // 進入下一關
  public function getNextGameLevel()
  {
    $this->gameLevel += 1;
  }

  // 取得遊戲記錄
  public function getRecord($enemy)
  {
    $this->endTime = date("Y-m-d H:i:s");
    $this->gameLevelPassed = ((!$enemy->isAlive()) && $this->gameLevel === 10) ? $this->gameLevel : ($this->gameLevel - 1);
  }
}
