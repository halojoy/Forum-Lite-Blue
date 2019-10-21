<?php

if (!isset($_GET['fid'])) {
    header('location:index.php');
    exit();
}else
    $fid = $_GET['fid'];

require('inc/init.php');
require('inc/header.php');

$db = new SQLite3('data/sqlite.db');
$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->querySingle($sql);
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="topics.php?fid=<?php echo $fid ?>"><?php echo $fname ?></a>
</div>

<?php
if (defined('UNAME')) {
?>
<div id="submitlink">
    <a href="newtopic.php?fid=<?php echo $fid ?>">New Topic</a>
</div>
<?php
}

echo '<div id="topics">';
echo '<table cellspacing="0" cellpadding="0">'."\n";
$sql = "SELECT * FROM topics WHERE fid=$fid ORDER BY lasttime DESC LIMIT 20";
$res = $db->query($sql);
while($topic = $res->fetchArray(SQLITE3_ASSOC)) {
    $tid = $topic['tid'];
    $subject = $topic['subject'];
    $lasttime = $topic['lasttime'];
    $sql = "SELECT userid FROM posts WHERE posttime=$lasttime";
    $userid = $db->querySingle($sql);
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $poster = $db->querySingle($sql);
    echo '<tr><td><a href="posts.php?tid='.$tid.'">'.$subject.'</a></td>';
    echo '<td class="topicdata">'.date('Y-m-d H:i',$lasttime).' ';
    echo $poster.'</td></tr>'."\n";
}
$res->finalize();
$db->close();
echo '</table>';
echo '</div>';
require('inc/footer.php');
