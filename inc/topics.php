<?php

if (!isset($_GET['fid'])) {
    header('location:index.php');
    exit();
}else
    $fid = $_GET['fid'];

require('inc/header.php');

$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->query($sql)->fetchColumn();
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=topics&fid=<?php echo $fid ?>"><?php echo $fname ?></a>
</div>

<?php
if (defined('UNAME')) {
?>
<div id="submitlink">
    <a href="?act=newtopic&fid=<?php echo $fid ?>">New Topic</a>
</div>
<?php
}

echo '<div id="topics">';
echo '<table cellspacing="0" cellpadding="0">'."\n";
$sql = "SELECT * FROM topics WHERE fid=$fid AND sticky=1 ORDER BY lasttime ASC";
foreach($db->query($sql) as $topic) {
    $tid = $topic->tid;
    $subject = $topic->subject;
    $lasttime = $topic->lasttime;
    $sql = "SELECT userid FROM posts WHERE posttime=$lasttime";
    $userid = $db->query($sql)->fetchColumn();
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $poster = $db->query($sql)->fetchColumn();
    echo '<tr><td>Sticky: <a href="?act=posts&tid='.$tid.'">'.$subject.'</a></td>';
    echo '<td class="topicdata">'.date('Y-m-d H:i',$lasttime).' ';
    echo $poster.'</td></tr>'."\n";
}
$sql = "SELECT * FROM topics WHERE fid=$fid AND sticky=0 ORDER BY lasttime DESC LIMIT 20";
foreach($db->query($sql) as $topic) {
    $tid = $topic->tid;
    $subject = $topic->subject;
    $lasttime = $topic->lasttime;
    $sql = "SELECT userid FROM posts WHERE posttime=$lasttime";
    $userid = $db->query($sql)->fetchColumn();
    $sql = "SELECT username FROM users WHERE uid=$userid";
    $poster = $db->query($sql)->fetchColumn();
    echo '<tr><td><a href="?act=posts&tid='.$tid.'">'.$subject.'</a></td>';
    echo '<td class="topicdata">'.date('Y-m-d H:i',$lasttime).' ';
    echo $poster.'</td></tr>'."\n";
}
$db = null;
echo '</table>';
echo '</div>';
require('inc/footer.php');
exit();
