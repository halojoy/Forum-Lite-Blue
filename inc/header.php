<!DOCTYPE html>
<html>
<head>
    <title><?php echo $forum_title ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/default.css">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="inc/favicon.ico">
</head>

<body>
<div id="wrapper">

<div id="head">
    <div id="title">
    <a style="color:#cc0000" href="index.php"><?php echo $forum_title ?></a>
    </div>
    <div id="loginlink">
<?php
if (defined('UNAME')) {
    echo '<a href="?act=logout">Logout</a>&nbsp;'.UNAME."\n";
    if (ULEVEL > 0) {
        echo '&nbsp;&nbsp;&nbsp;<a href="?act=admin">Admin</a>'."\n";
        if ($dbase == 'sqlite' && ULEVEL > 1)
            echo '&nbsp;&nbsp;&nbsp;<a href="?act=dbadmin">DB-Admin</a>'."\n";
    }
}else{
    echo '<a href="?act=login">Login</a>&nbsp;&nbsp;or&nbsp;'."\n";
    echo '<a href="?act=signup">Sign Up</a>'."\n";
}
?>
    </div>
    <br>
</div>
