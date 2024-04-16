<?php

require 'vendor/autoload.php';

use Classes\Enemy;

it('generates 10 unique enemy names', function () {
  // Arrange
  $enemyNames = Enemy::generateEnemyNames();

  // Act
  $uniqueEnemyNames = array_unique($enemyNames);

  // Assert
  expect(count($uniqueEnemyNames))->toBe(10);
});
