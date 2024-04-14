# BECamp_T13_HW1_OOP_Helen
A simple battle game

## Features
- Create a new character and start battling.
- View game records.
- Leave game.

## Prerequisites

- PHP 8.3.3
- MySQL

## Installation

1. Please make sure you have php installed first.

2. Clone the repository.

```
git clone https://github.com/Goodidea-backend-camp/BECamp_T13_HW1_OOP_Helen
```

3. Move to the project folder via terminal and execute the code below to install the dependencies.

```
composer install
```
4. Refer to .env.example to setup database variable.

5. Execute the code below in MySQL to create the game database.

```
CREATE DATABASE game;
```
```
USE game;
```
```
CREATE TABLE records (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  player_name VARCHAR(50),
  level_passed INT,
  start_time datetime,
  end_time datetime
);
```

6. Execute the code below in terminal and start the game.

```
php index.php
```