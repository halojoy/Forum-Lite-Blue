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
echo '<div id="forums">'."\n";
echo '<table cellspacing="2" cellpadding="2">';
$sql = "SELECT * FROM forums ORDER BY forder";
foreach($db->query($sql) as $forum) {
    $fid   = $forum->fid;
    $fname = $forum->fname;
    echo '<tr><td><a href="?act=admtopics&fid='.$fid.'">'.$fname.'</a></td>';
    if (ULEVEL > 1)
        echo '<td> - <a href="?act=dodelete&fid='.$fid.'">
                                <em>Delete forum</em></a></td></tr>'."\n";
    else
        echo '<td></td></tr>';
}
$db = null;
echo '</table>';
echo '</div>'."\n";
require('inc/footer.php');
exit();
