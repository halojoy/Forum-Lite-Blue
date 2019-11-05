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
if (ULEVEL > 1) {
if (isset($_POST['fid'])) {
    $fid = $_POST['fid'];
    $sql = "SELECT tid FROM topics WHERE fid=$fid";
    foreach($db->query($sql) as $topic) {
        $tid = $topic->tid;
        $sql = "SELECT pid FROM posts WHERE tid=$tid";
        foreach($db->query($sql) as $post) {
            $pid =  $post->pid;
            $sql = "DELETE FROM posts WHERE pid=$pid";
            $db->exec($sql);
        }
        $sql =  "DELETE FROM topics WHERE tid=$tid";
        $db->exec($sql);
    }
    $sql =  "DELETE FROM forums WHERE fid=$fid";
    $db->exec($sql);
    $db = null;
    header('location: ?act=admforums');
    exit();
}

if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];
    $sql = "SELECT fname FROM forums WHERE fid=$fid";
    $fname = $db->query($sql)->fetchColumn();
    $db = null;
    echo '<div class="paddin">';
    echo $fname;
?>
    <br><br>
    <form method="post">
    <input type="hidden" name="fid" value="<?php echo $fid ?>">
    <input type="submit" value="Delete"
            onclick="return confirm('Are you sure you want to Delete?')">
    <input type="button" value="Cancel"
            onClick="window.location.href='?act=admforums'"> 
    </form>
<?php
    echo '</div>';
exit();
}
}

if (isset($_POST['tid'])) {
    $tid = $_POST['tid'];
    $sql = "SELECT pid FROM posts WHERE tid=$tid";
    foreach($db->query($sql) as $post) {
        $pid =  $post->pid;
        $sql = "DELETE FROM posts WHERE pid=$pid";
        $db->exec($sql);
    }
    $sql =  "DELETE FROM topics WHERE tid=$tid";
    $db->exec($sql);
    $db = null;
    header('location: ?act=admforums');
    exit();
}
if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];
    $sql = "SELECT subject FROM topics WHERE tid=$tid";
    $subject = $db->query($sql)->fetchColumn();
    $db = null;
    echo '<div class="paddin">';
    echo $subject;
?>
    <br><br>
    <form method="post">
    <input type="hidden" name="tid" value="<?php echo $tid ?>">
    <input type="submit" value="Delete"
            onclick="return confirm('Are you sure you want to Delete?')">
    <input type="button" value="Cancel"
            onClick="window.location.href='?act=admforums'"> 
    </form>
<?php
    echo '</div>';
exit();
}

if (isset($_POST['pid'])) {
    //dodeletepost
    $pid = $_POST['pid'];
    $sql = "SELECT tid FROM posts WHERE pid=$pid";
    $tid = $db->query($sql)->fetchColumn();
    $sql = "DELETE FROM posts WHERE pid=$pid";
    $db->exec($sql);
    $sql = "SELECT posttime FROM posts WHERE tid=$tid ORDER BY posttime DESC";
    $posttime = $db->query($sql)->fetchColumn();
    $sql = "UPDATE topics SET lasttime=$posttime WHERE tid=$tid";
    $db->exec($sql);
    $db = null;
    header('location: ?act=admforums');
    exit();
}
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    require 'markdown/autoload.php';
    $parser = new \cebe\markdown\GithubMarkdown();
    echo '<div id="posts">';
    $sql = "SELECT * FROM posts WHERE pid=$pid";
    $post = $db->query($sql)->fetch();
    $pid = $post->pid;
    $date = date('Y-m-d H:i', $post->posttime);
    $userid = $post->userid;
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $username = $db->query($sql)->fetchColumn();
    echo '<div class="posthead">'.$date.' '.$username.'</div>'."\n";
    $message = $parser->parse($post->message);
    echo '<div class="postbody">'.$message.'</div>'."\n";
    $db = null;
    $parser = null;
    echo '</div>';
?>
    <div class="paddin">
    <form method="post">
    <input type="hidden" name="pid" value="<?php echo $pid ?>">
    <input type="submit" value="Delete"
            onclick="return confirm('Are you sure you want to Delete?')">
    <input type="button" value="Cancel"
            onClick="window.location.href='?act=admforums'"> 
    </form>
    </div>
<?php
}
require('inc/footer.php');
exit();

