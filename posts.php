<?php

if (!isset($_GET['tid'])) {
    header('location:index.php');
    exit();
}else
    $tid = $_GET['tid'];

require('inc/init.php');
require('inc/header.php');

$db = new SQLite3('data/sqlite.db');
$sql = "SELECT fid,subject FROM topics WHERE tid=$tid";
$topic = $db->querySingle($sql, true);
$fid     = $topic['fid'];
$subject = $topic['subject'];
$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->querySingle($sql);
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="topics.php?fid=<?php echo $fid ?>"><?php echo $fname ?></a> &#187;
    <a href="posts.php?tid=<?php echo $tid ?>"><?php echo $subject ?></a>
    <span style="float:right"><a href="#bottom">#Bottom</a></span>
</div>

<?php
if (defined('UNAME')) {
?>
<div id="submitlink">
    <a href="newpost.php?tid=<?php echo $tid ?>">Post Reply</a>
</div>
<?php
}

echo '<div id="posts">';
$sql = "SELECT * FROM posts WHERE tid=$tid";
$res = $db->query($sql);
while($post = $res->fetchArray(SQLITE3_ASSOC)) {
    $date = date('Y-m-d H:i', $post['posttime']);
    $userid = $post['userid'];
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $username = $db->querySingle($sql);
    echo '<div class="posthead">'.$date.' '.$username.'</div>'."\n";
    echo '<div class="postbody">'.$post['message'].'</div>'."\n";
}
$res->finalize();
$db->close();
echo '<div id="bottom"></div>';
echo '</div>';
require('inc/footer.php');
