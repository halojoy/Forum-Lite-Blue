<?php

if (!isset($_GET['tid'])) {
    header('location:index.php');
    exit();
}else
    $tid = $_GET['tid'];

require('inc/header.php');

$sql = "SELECT fid,subject,locked FROM topics WHERE tid=$tid";
$topic = $db->query($sql)->fetch();
$fid     = $topic->fid;
$subject = $topic->subject;
$locked  = $topic->locked;
$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->query($sql)->fetchColumn();
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=topics&fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="?act=posts&tid=<?php echo $tid ?>"><?php echo $subject ?></a>
    <span style="float:right"><a href="#bottom">#Bottom</a></span>
</div>

<?php
if (defined('UNAME') && !$locked) {
?>
<div id="submitlink">
    <a href="?act=newpost&tid=<?php echo $tid ?>">Post Reply</a>
</div>
<?php
}elseif (defined('UID') && UID == 1 && $locked) {
?>
<div id="submitlink">
    <a href="?act=newpost&tid=<?php echo $tid ?>">Post Reply</a> (Locked)
</div>
 <?php
}elseif (defined('UNAME')) {
?>
<div id="submitlink">
    Locked topic
</div>
<?php
}

require 'markdown/autoload.php';
$parser = new \cebe\markdown\GithubMarkdown();
echo '<div id="posts">';
$sql = "SELECT * FROM posts WHERE tid=$tid";
foreach($db->query($sql) as $post) {
    $date = date('Y-m-d H:i', $post->posttime);
    $userid = $post->userid;
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $username = $db->query($sql)->fetchColumn();
    echo '<div class="posthead">'.$date.' '.$username.'</div>'."\n";
    $message = $parser->parse($post->message);
    echo '<div class="postbody">'.$message.'</div>'."\n";
}
$db = null;
$parser = null;
echo '<div id="bottom"></div>';
echo '</div>';
require('inc/footer.php');
exit();
