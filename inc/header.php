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
    <div id="title"><?php echo $forum_title ?></div>
    <div id="loginlink">
<?php
if (defined('UNAME')) {
    echo '<a href="logout.php">Logout</a>&nbsp;'.UNAME."\n";
    if (UID == 1) {
        echo '&nbsp;&nbsp;&nbsp;<a href="pla1982fix.php">DB-Admin</a>'."\n";
        echo '&nbsp;&nbsp;&nbsp;<a href="newforum.php">Create New Forum</a>'."\n";
    }
}else{
    echo '<a href="login.php">Login</a>&nbsp;&nbsp;or&nbsp;'."\n";
    echo '<a href="signup.php">Sign Up</a>'."\n";
}
?>
    </div>
    <br>
</div>
