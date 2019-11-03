<?php
    $sql = "CREATE TABLE IF NOT EXISTS forums (
     fid INTEGER PRIMARY KEY,
     fname    TEXT,
     descript TEXT,
     forder   INTEGER )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS topics (
     tid INTEGER PRIMARY KEY,
     fid INTEGER,
     subject  TEXT,
     userid   INTEGER,
     lasttime INTEGER,
     locked   INTEGER,
     sticky   INTEGER )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS posts (
     pid INTEGER PRIMARY KEY,
     tid INTEGER,
     message  TEXT,
     userid   INTEGER,
     posttime INTEGER )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS users (
     uid      INTEGER PRIMARY KEY,
     username TEXT, 
     password TEXT, 
     ip       TEXT )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS banned (
     bid      INTEGER PRIMARY KEY,
     username TEXT,
     ip       TEXT )";
    $db->exec($sql);
