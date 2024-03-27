<?php

class View
{
  // 清空螢幕畫面
  public static function clearScreen()
  {
    echo "\033[2J\033[H";
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
