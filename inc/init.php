<?php

$start = microtime(true);

session_start();

if (isset($_COOKIE['username'])) {
    define('UNAME', $_COOKIE['username']);
    define('UID',   $_COOKIE['userid']);
}

$db = new PDO($dsn, $dbuser, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
