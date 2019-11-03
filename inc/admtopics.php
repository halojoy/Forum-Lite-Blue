<?php

if (!defined('UID') || UID != 1) exit();

require('inc/header.php');

if (!isset($_GET['fid'])) {
    header('location:index.php');
    exit();
}else
    $fid = $_GET['fid'];

$sql = "SELECT fname FROM forums WHERE fid=$fid";
$fname = $db->query($sql)->fetchColumn();
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a> &#187;
    <a href="?act=admforums">Admin Forums</a> &#187;
    <a href="?act=admtopics&fid=<?php echo $fid ?>"><?php echo $fname ?></a>
</div>

<?php

echo '<div id="topics">';
echo '<table cellspacing="2" cellpadding="2">'."\n";
$sql = "SELECT * FROM topics WHERE fid=$fid ORDER BY lasttime DESC LIMIT 20";
foreach($db->query($sql) as $topic) {
    $tid     = $topic->tid;
    $subject = $topic->subject;
    $locked  = $topic->locked;
    $sticky  = $topic->sticky;
    if ($locked)
        $altlink = ' <a href="?act=altlock&tid='.$tid.'"><em><b>Locked</b></em></a>';
    else
        $altlink = ' <a href="?act=altlock&tid='.$tid.'"><em>Locked</em></a>';
    if ($sticky)
        $altlink .= ' <a href="?act=altstick&tid='.$tid.'"><em><b>Sticky</b></em></a>';
    else
        $altlink .= ' <a href="?act=altstick&tid='.$tid.'"><em>Sticky</em></a>';

    echo '<tr><td><a href="?act=admposts&tid='.$tid.'">'.$subject.'</a></td>';
    echo '<td> - '.$altlink.' <a href="?act=dodelete&tid='.$tid.
                                '"><em>Delete topic</em></a></td></tr>'."\n";
}
$db = null;
echo '</table>';
echo '</div>';
require('inc/footer.php');
exit();
