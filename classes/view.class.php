<?php

class View
{
  // 清空螢幕畫面
  public static function clearScreen()
  {
    echo "\033[2J\033[H";
  }

  // 離開遊戲畫面
  public static function exitGame()
  {
    self::clearScreen();
    echo "Thanks for playing!\n";
  }

  // 進入開始遊戲畫面
  public static function getMenu()
  {
    self::clearScreen();
    echo "歡迎來到對戰遊戲!\n";
    echo "(1)新建角色並開始對戰\n";
    echo "(2)查看歷史記錄\n";
    echo "(3)離開遊戲\n";
    $choice = readline("請輸入你的選項: ");
    if ($choice == "1") {
      return;
    } else if ($choice == "2") {
      echo "顯示歷史對戰紀錄\n";
      readline("按下Enter後回到menu...\n");
      self::getMenu();
    } else if ($choice == "3") {
      self::exitGame();
    } else {
      readline("輸入的選項無效，請按下Enter後重新輸入！\n");
      self::getMenu();
    }
  }

  // 進入關卡
  public static function getGameLevel($enemy, $gameLevel)
  {
    self::clearScreen();
    echo '進入第' . $gameLevel . '關' . "\n";
    echo '第' . $gameLevel . '關敵人為' . $enemy->name . "\n";
  }

  // 更新對戰資訊
  public static function updateInfo($player, $enemy)
  {
    self::clearScreen();
    printf("%-20s| %-20s\n", 'Player', 'Enemy');
    printf("%'-40s\n", '');
    printf("%-20s| %-20s\n", 'HP:' . $player->healthPoint, 'HP:' . $enemy->healthPoint);
  }

  // 取得對戰結果
  public static function getResult($gameLevel, $winner)
  {
    echo '第' . $gameLevel . '關挑戰結果：' . $winner->name . '勝利' . "\n";
  }
}
