<?php

if (!defined('ULEVEL') || ULEVEL < 1) exit();

require('inc/header.php');

if (!isset($_GET['tid'])) {
    header('location:index.php');
    exit();
}else
    $tid = $_GET['tid'];

$sql = "SELECT fid,subject FROM topics WHERE tid=$tid";
$topic = $db->query($sql)->fetch();
$fid     = $topic->fid;
$subject = $topic->subject;
$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->query($sql)->fetchColumn();
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a> &#187;
    <a href="?act=admforums">Admin Forums</a> &#187;
    <a href="?act=admtopics&fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="?act=admposts&tid=<?php echo $tid ?>"><?php echo $subject ?></a>
</div>

<?php

require 'markdown/autoload.php';
$parser = new \cebe\markdown\GithubMarkdown();
echo '<div id="posts">';
$sql = "SELECT * FROM posts WHERE tid=$tid";
$count = 0;
foreach($db->query($sql) as $post) {
    ++$count;
    $pid = $post->pid;
    $date = date('Y-m-d H:i', $post->posttime);
    $userid = $post->userid;
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $username = $db->query($sql)->fetchColumn();
    echo '<div class="posthead">'.$date.' '.$username.'</div>'."\n";
    $message = $parser->parse($post->message);
    echo '<div class="postbody">'.$message;
    if ($count != 1) {
        echo '<a href="?act=doedit&pid='.$pid.'">Edit</a>&nbsp;&nbsp;';
        echo '<a href="?act=dodelete&pid='.$pid.'">Delete</a>';
    }
    echo '</div>'."\n";
}
$db = null;
$parser = null;
echo '<div id="bottom"></div>';
echo '</div>';
require('inc/footer.php');
exit();
