# 對戰遊戲
對戰遊戲是一個使用 OOP 概念設計的簡易遊戲，在終端機上執行。

<img width="500" alt="對戰遊戲截圖" src="https://github.com/user-attachments/assets/92d6887a-8dd5-4ac6-9bc5-6bafb2cd49a1">

## 功能
多種玩家角色類型、與怪物對戰、查看遊戲紀錄

## 觀念
OOP（Classes/Objects、Constructor、Access Modifiers、Inheritance、Class Constants、Static Methods、Namespace）

## 工具
PHP、MySQL、Terminal

## 安裝步驟

1. Please make sure you have PHP and MySQL installed first.

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
