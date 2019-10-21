<?php

if (!is_file('data/sqlite.db'))
    require('inc/setup.php');

require('inc/init.php');
require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a>
</div>

<?php
echo '<div id="forums">'."\n";
echo '<table cellspacing="0" cellpadding="0">';
$db = new SQLite3('data/sqlite.db');
$sql = "SELECT * FROM forums";
$res = $db->query($sql);
while($forum = $res->fetchArray(SQLITE3_ASSOC)) {
    $fid = $forum['fid'];
    $fname = $forum['fname'];
    $descript = $forum['descript'];
    $sql = "SELECT tid,subject,lasttime FROM topics 
                WHERE fid=$fid ORDER BY lasttime DESC";
    $topic = $db->querySingle($sql, true);
    if ($topic) {
        $tid = $topic['tid'];
        $subject = $topic['subject'];
        $lasttime = $topic['lasttime'];
    }
    echo '<tr><td class="forumname">
              <a href="topics.php?fid='.$fid.'">'.$fname.'</a></td>';
    echo '<td class="lasttopic">';
    if ($topic) {
        echo 'Last post '.date('Y-m-d H:i', $lasttime).' in ';
        echo '<a href="posts.php?tid='.$tid.'">'.$subject.'</a>';
    }
    echo '</td></tr>'."\n";
    echo '<tr><td class="description" colspan="2">'.$descript.
                                            '</td></tr>'."\n";
}
$res->finalize();
$db->close();
echo '</table>';
echo '</div>'."\n";
require('inc/footer.php');
