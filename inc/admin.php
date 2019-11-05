<?php

if (!defined('ULEVEL') || ULEVEL < 1) exit();

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a>
</div>

<div id="admin"><br>
<?php
if (ULEVEL > 1) {
?>
<a href="?act=newforum">Create New Forum</a><br>
<a href="?act=forder">Forum Order</a><br>
<a href="?act=admusers">Admin Users</a><br>
<?php
}
?>
<a href="?act=admforums">Admin Forums</a><br>
<br></div>

<?php
require('inc/footer.php');
exit();
