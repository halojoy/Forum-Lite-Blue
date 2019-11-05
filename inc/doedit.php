<?php

if (!defined('ULEVEL') || ULEVEL < 1) exit();

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a> &#187;
    <a href="?act=admforums">Admin Forums</a>
</div>

<?php
if (isset($_POST['message'])) {
    $pid     = $_POST['pid'];
    $message = $_POST['message'];
    $sql = "UPDATE posts SET message='$message' WHERE pid=$pid";
    $db->exec($sql);
    $db = null;
    header('location: ?act=admforums');
    exit();
}

echo '<div class="paddin">';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $sql = "SELECT * FROM posts WHERE pid=$pid";
    $row = $db->query($sql)->fetch();
    $db = null;
?>
    <form method="post">
    <?php echo date('Y-m-d', $row->posttime) ?><br>
    <textarea name="message" rows="10" 
                cols="60"><?php echo $row->message ?></textarea><br><br>
    <input type="hidden" name="pid" value="<?php echo $pid ?>">
    <input type="submit" value="Edit">
    <input type="button" value="Cancel"
            onClick="window.location.href='?act=admforums'">
    </form>
    </div>
<?php
}
require('inc/footer.php');
exit();
