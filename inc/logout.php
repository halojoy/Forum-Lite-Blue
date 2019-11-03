<?php

if (!isset($_COOKIE['username'])) {
    header('location:index.php');
    exit();
}else{
    setcookie('username', '', time() - 3600);
    setcookie('userid',   '', time() - 3600);
    header('location:index.php');
    exit();
}
