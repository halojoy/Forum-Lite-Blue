<?php

require('inc/init.php');
if (!defined('UNAME')) {
    header('location:index.php');
    exit();
}
session_start();
require('inc/header.php');

$db = new SQLite3('data/sqlite.db');
if (isset($_POST['message'])) {
    require('inc/csrf_check.php');
    $tid = $_POST['tid'];
    require 'markdown/autoload.php';
    $parser = new \cebe\markdown\GithubMarkdown();
    $parser->html5 = true;
    $parser->enableNewlines = true;
    $data = $_POST['message'];
    $message = $parser->parse($data);
    $userid = UID;
    $time = time();
    if (strlen($message) < 3) {
        header('location:index.php');
        exit();
    }

    $sql = "INSERT INTO posts (tid,message,userid,posttime)
                        VALUES (?, ?, ?, ?)";
    $stm = $db->prepare($sql);
    $stm->bindParam(1, $tid,     SQLITE3_INTEGER);
    $stm->bindParam(2, $message, SQLITE3_TEXT);
    $stm->bindParam(3, $userid,  SQLITE3_INTEGER);
    $stm->bindParam(4, $time,    SQLITE3_INTEGER);
    $stm->execute();
    $stm->close();
    $sql = "UPDATE topics SET lasttime=$time WHERE tid=$tid";
    $db->exec($sql);
    $db->close();
    header('location:posts.php?tid='.$tid);
    exit();
}

if (!isset($_GET['tid'])) {
    header('location:index.php');
    exit();
}else
    $tid = $_GET['tid'];

$sql = "SELECT fid,subject FROM topics WHERE tid=$tid";
$topic = $db->querySingle($sql, true);
$fid = $topic['fid'];
$subject = $topic['subject'];
$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->querySingle($sql);
$db->close();
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="topics.php?fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="posts.php?tid=<?php echo $tid ?>"><?php echo $subject ?></a> &#187;
    <a href="newpost.php?tid=<?php echo $tid ?>">New Reply</a>
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
