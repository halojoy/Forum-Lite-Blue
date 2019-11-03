<?php

require('inc/setup.php');

require('inc/init.php');
require('inc/actions.php');

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a>
</div>

<?php
echo '<div id="forums">'."\n";
echo '<table cellspacing="2" cellpadding="1">';

$sql = "SELECT * FROM forums ORDER BY forder";
foreach($db->query($sql) as $forum) {
    $fid = $forum->fid;
    $fname = $forum->fname;
    $descript = $forum->descript;
    $sql = "SELECT tid,subject,lasttime FROM topics 
                WHERE fid=$fid ORDER BY lasttime DESC";
    $topic = $db->query($sql)->fetch();
    if ($topic) {
        $tid = $topic->tid;
        $subject = $topic->subject;
        $lasttime = $topic->lasttime;
    }
    echo '<tr><td class="forumname">
              <a href="?act=topics&fid='.$fid.'">'.$fname.'</a></td>';
    echo '<td class="lasttopic">';
    if ($topic) {
        echo 'Last post '.date('Y-m-d H:i', $lasttime).' in ';
        echo '<a href="?act=posts&tid='.$tid.'">'.$subject.'</a>';
    }
    echo '</td></tr>'."\n";
    echo '<tr><td class="description" colspan="2">'.$descript.
                                            '</td></tr>'."\n";
}
$db = null;
echo '</table>';
echo '</div>'."\n";
require('inc/footer.php');
exit();
