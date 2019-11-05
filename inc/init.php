<?php

$start = microtime(true);

session_start();

$db = new PDO($dsn, $dbuser, $dbpass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

if (isset($_COOKIE['username'])) {
    define('UNAME',  $_COOKIE['username']);
    define('UID',    $_COOKIE['userid']);
    define('ULEVEL', $_COOKIE['userlevel']);
    $uid = UID;
    $sql = "SELECT logged FROM users WHERE uid=$uid";
    $logged = $db->query($sql)->fetchColumn();
    if (!$logged) {
        require('inc/logout.php');
    }
}
