<?php

if (!defined('UID') || UID != 1) exit();

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a> &#187;
    <a href="?act=admusers">Admin Users</a>
</div>

<?php
if (isset($_POST['uid'])) {
    $uid = $_POST['uid'];
    $sql =  "DELETE FROM users WHERE uid=$uid";
    $db->exec($sql);
    $db = null;
    header('location: ?act=admusers');
    exit();
}
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $sql = "SELECT username,ip FROM users WHERE uid=$uid";
    $row = $db->query($sql)->fetch();
    $db = null;
    echo '<div id="users"><br>';
    echo $row->username.' '.$row->ip;
?>
    <br><br>
    <form method="post">
    <input type="hidden" name="uid" value="<?php echo $uid ?>">
    <input type="submit" value="Delete User"
            onclick="return confirm('Are you sure you want to Delete?')">
    <input type="button" value="Cancel"
            onClick="window.location.href='?act=admusers'"> 
    </form>
<?php
    echo '</div>';
}
require('inc/footer.php');
exit();
