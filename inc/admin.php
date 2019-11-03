<?php

if (!defined('UID') || UID != 1) exit();

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a>
</div>

<div id="admin"><br>
<a href="?act=newforum">Create New Forum</a><br>
<a href="?act=forder">Forum Order</a><br>
<a href="?act=admforums">Admin Forums</a><br>
<a href="?act=admusers">Admin Users</a><br>
<br></div>

<?php
require('inc/footer.php');
exit();
