<?php

class Record
{
  // Properties
  public $playerName;
  public $gameLevel;
  public $gameLevelPassed;
  public $startTime;
  public $endTime;

  // Constructor
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
    $this->gameLevelPassed = ($enemy->healthPoint <= 0 && $this->gameLevel === 10) ? $this->gameLevel : ($this->gameLevel - 1);
  }
}
