<?php

if (!defined('UNAME')) {
    header('location:index.php');
    exit();
}
require('inc/header.php');

if (isset($_POST['message'])) {
    require('inc/csrf_check.php');
    $tid     = $_POST['tid'];
    $message = $_POST['message'];
    $message = preg_replace('#<(?!https?).*?>#', '', $message);
    $userid  = UID;
    $time    = time();
    if (strlen($message) < 3) {
        header('location:index.php');
        exit();
    }

    $sql = "INSERT INTO posts (tid,message,userid,posttime)
                        VALUES (?, ?, ?, ?)";
    $sth = $db->prepare($sql);
    $sth->bindParam(1, $tid,     PDO::PARAM_INT);
    $sth->bindParam(2, $message, PDO::PARAM_STR);
    $sth->bindParam(3, $userid,  PDO::PARAM_INT);
    $sth->bindParam(4, $time,    PDO::PARAM_INT);
    $sth->execute();
    $sth = null;
    $sql = "UPDATE topics SET lasttime=$time WHERE tid=$tid";
    $db->exec($sql);
    $db = null;
    header('location:?act=posts&tid='.$tid);
    exit();
}

if (!isset($_GET['tid'])) {
    header('location:index.php');
    exit();
}else
    $tid = $_GET['tid'];

$sql = "SELECT fid,subject FROM topics WHERE tid=$tid";
$topic = $db->query($sql)->fetch();
$fid = $topic->fid;
$subject = $topic->subject;
$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->query($sql)->fetchColumn();
$db = null;
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=topics&fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="?act=posts&tid=<?php echo $tid ?>"><?php echo $subject ?></a> &#187;
    <a href="?act=newpost&tid=<?php echo $tid ?>">New Reply</a>
</div>

<div class="paddin">
    Subject: '<?php echo $subject ?>'
    <br><br>
    <form method="post">
        Message (markdown):<br>
        <textarea name="message" rows="15" cols="80" required></textarea>
        <br><br>
        <input type="hidden" name="tid" value="<?php echo $tid ?>">
        <?php require('inc/csrf_create.php') ?>
        <input type="submit">&nbsp;&nbsp;
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
    </form>
</div>
<?php
require('inc/footer.php');
exit();
