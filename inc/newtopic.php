<?php

if (!defined('UNAME')) {
    header('location:index.php');
    exit();
}
require('inc/header.php');

if (isset($_POST['subject'])) {
    require('inc/csrf_check.php');
    $fid     = $_POST['fid'];
    $subject = trim($_POST['subject']);
    $subject = htmlspecialchars($subject, ENT_HTML5);
    $message = $_POST['message'];
    $message = preg_replace('#<(?!https?).*?>#', '', $message);
    $userid  = UID;
    $time    = time();
    $locked = 0;
    $sticky = 0;
    if (isset($_POST['locked'])) $locked = 1;
    if (isset($_POST['sticky'])) $sticky = 1;
    if (strlen($subject) < 3 || strlen($message) < 3) {
        header('location:index.php');
        exit();
    }
    $sql = "INSERT INTO topics (fid,subject,userid,lasttime,locked,sticky)
                        VALUES (?, ?, ?, ?, ?, ?)";
    $sth = $db->prepare($sql);
    $sth->bindParam(1, $fid,     PDO::PARAM_INT);
    $sth->bindParam(2, $subject, PDO::PARAM_STR);
    $sth->bindParam(3, $userid,  PDO::PARAM_INT);
    $sth->bindParam(4, $time,    PDO::PARAM_INT);
    $sth->bindParam(5, $locked,  PDO::PARAM_INT);
    $sth->bindParam(6, $sticky,  PDO::PARAM_INT);
    $sth->execute();
    $sth = null;
    $tid = $db->lastInsertId();
    $sql = "INSERT INTO posts  (tid,message,userid,posttime)
                        VALUES (?, ?, ?, ?)";
    $sth = $db->prepare($sql);
    $sth->bindParam(1, $tid,     PDO::PARAM_INT);
    $sth->bindParam(2, $message, PDO::PARAM_STR);
    $sth->bindParam(3, $userid,  PDO::PARAM_INT);
    $sth->bindParam(4, $time,    PDO::PARAM_INT);
    $sth->execute();
    $sth = null;
    $db = null;
    header('location:?act=posts&tid='.$tid);
    exit();
}

if (!isset($_GET['fid'])) {
    header('location:index.php');
    exit();
}else
    $fid = $_GET['fid'];

$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->query($sql)->fetchColumn();
$db = null;
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=topics&fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="?act=newtopic&fid=<?php echo $fid ?>">New Topic</a>
</div>

<div class="paddin">
    <form method="post">
        Subject:<br>
        <input name="subject" size="50" maxlength="60" required>
        <br>
        Message (markdown):<br>
        <textarea name="message" rows="15" cols="80" required></textarea>
        <br><br>
        <input type="hidden" name="fid" value="<?php echo $fid ?>">
        <?php require('inc/csrf_create.php') ?>
        <?php
            if (ULEVEL > 0) {
        ?>
        <input type="checkbox" name="locked" value="1"> Locked<br>
        <input type="checkbox" name="sticky" value="1"> Sticky<br>
        <?php
            }
        ?>
        <input type="submit">&nbsp;&nbsp;
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
    </form>
</div>
<?php
require('inc/footer.php');
exit();
