<?php

$start = microtime(true);

require('data/config.php');

if (isset($_COOKIE['username'])) {
    define('UNAME', $_COOKIE['username']);
    define('UID',   $_COOKIE['userid']);
}
