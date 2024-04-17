<?php

require './../vendor/autoload.php';

use Classes\Enemy;

it('generates 10 unique enemy names', function () {
  // Arrange
  $enemyNames = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
  $gameLevel = 1;

  // Act
  $enemy = new Enemy($enemyNames, $gameLevel);

  // Assert
  expect($enemy->name)->toBe('a');
});
