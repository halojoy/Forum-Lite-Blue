<?php

if (!defined('ULEVEL') || ULEVEL < 2) exit();

if (isset($_GET['uid']))
    $uid = $_GET['uid'];
else{
    header('location: index.php');
    exit();
}
if (isset($_GET['lev']))
    $lev = $_GET['lev'];
else{
    header('location: index.php');
    exit();
}

$sql = "UPDATE users SET ulevel=$lev, logged=0 WHERE uid=$uid";
$db->exec($sql);
$db = null;
header('location: ?act=admusers');
exit();
