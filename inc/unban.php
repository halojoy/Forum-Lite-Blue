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
if (isset($_POST['bid'])) {
    $bid = $_POST['bid'];
    $sql = "DELETE FROM banned WHERE bid=$bid";
    $db->exec($sql);
    $db = null;
    header('location: ?act=admusers');
    exit();
}

if (isset($_GET['bid'])) {
    $bid = $_GET['bid'];
    $sql = "SELECT username,ip FROM banned WHERE bid=$bid";
    $row = $db->query($sql)->fetch();
    $db = null;
    echo '<div id="users"><br>';
    echo $row->username.' '.$row->ip;
?>
    <br><br>
    <form method="post">
    <input type="hidden" name="bid" value="<?php echo $bid ?>">
    <input type="submit" value="Unban User"
            onclick="return confirm('Are you sure you want to UnBan?')">
    <input type="button" value="Cancel"
            onClick="window.location.href='?act=admusers'"> 
    </form>
<?php
    echo '</div>';
}
require('inc/footer.php');
exit();
