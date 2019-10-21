<?php

require('inc/init.php');
if (!defined('UNAME')) {
    header('location:index.php');
    exit();
}
session_start();
require('inc/header.php');

$db = new SQLite3('data/sqlite.db');
if (isset($_POST['subject'])) {
    require('inc/csrf_check.php');
    $fid     = $_POST['fid'];
    $subject = trim($_POST['subject']);
    $subject = htmlspecialchars($subject, ENT_HTML5);
    require 'markdown/autoload.php';
    $parser = new \cebe\markdown\GithubMarkdown();
    $parser->html5 = true;
    $parser->enableNewlines = true;
    $data    = $_POST['message'];
    $message = $parser->parse($data);
    $userid  = UID;
    $time = time();
    if (strlen($subject) < 3 || strlen($message) < 3) {
        header('location:index.php');
        exit();
    }

    $sql = "INSERT INTO topics (fid,subject,userid,lasttime)
                        VALUES (?, ?, ?, ?)";
    $stm = $db->prepare($sql);
    $stm->bindParam(1, $fid,     SQLITE3_INTEGER);
    $stm->bindParam(2, $subject, SQLITE3_TEXT);
    $stm->bindParam(3, $userid,  SQLITE3_INTEGER);
    $stm->bindParam(4, $time,    SQLITE3_INTEGER);
    $stm->execute();
    $stm->close();
    $tid = $db->lastInsertRowID();
    $sql = "INSERT INTO posts  (tid,message,userid,posttime)
                        VALUES (?, ?, ?, ?)";
    $stm = $db->prepare($sql);
    $stm->bindParam(1, $tid,     SQLITE3_INTEGER);
    $stm->bindParam(2, $message, SQLITE3_TEXT);
    $stm->bindParam(3, $userid,  SQLITE3_INTEGER);
    $stm->bindParam(4, $time,    SQLITE3_INTEGER);
    $stm->execute();
    $stm->close();
    $db->close();
    header('location:posts.php?tid='.$tid);
    exit();
}

if (!isset($_GET['fid'])) {
    header('location:index.php');
    exit();
}else
    $fid = $_GET['fid'];

$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->querySingle($sql);
$db->close();
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="topics.php?fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="newtopic.php?fid=<?php echo $fid ?>">New Topic</a>
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
        <input type="submit">&nbsp;&nbsp;
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
    </form>
</div>
<?php
require('inc/footer.php');
