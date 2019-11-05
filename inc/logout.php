<?php

if (!isset($_COOKIE['username'])) {
    header('location:index.php');
    exit();
}else{
    $uid = UID;
    $sql = "UPDATE users SET logged=0 WHERE uid=$uid";
    $db->exec($sql);
    $db = null;
    setcookie('username', '', time() - 3600);
    setcookie('userid',   '', time() - 3600);
    setcookie('userlevel','', time() - 3600);
    header('location:index.php');
    exit();
}
