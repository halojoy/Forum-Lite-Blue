<?php
    $sql = "CREATE TABLE IF NOT EXISTS forums (
     fid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     fname    VARCHAR(50),
     descript VARCHAR(100),
     forder   INT )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS topics (
     tid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     fid      INT,
     subject  VARCHAR(100),
     userid   INT,
     lasttime INT,
     locked   INT,
     sticky   INT )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS posts (
     pid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     tid      INT,
     message  TEXT,
     userid   INT,
     posttime INT )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS users (
     uid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50), 
     password VARCHAR(100), 
     ip       VARCHAR(50) )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS banned (
     bid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     username VARCHAR(50),
     ip       VARCHAR(50) )";
    $db->exec($sql);
