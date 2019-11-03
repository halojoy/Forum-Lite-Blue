<?php

if (!defined('UID') || UID != 1) exit();

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a> &#187;
    <a href="?act=forder">Forum Order</a>
</div>

<?php

if (isset($_POST['disp_ord'])) {
    $neworder = $_POST['in'];
    foreach ($neworder as $fid => $disp_ord) {
        $sql = "UPDATE forums SET forder=$disp_ord WHERE fid=$fid";
        $db->exec($sql);
    }
}

$sql = "SELECT * FROM forums ORDER BY forder";
$forums = $db->query($sql)->fetchAll();
?>
<div class="paddin">
<strong>Forum Display Order</strong>
<br>
<form method="post">
    <table>
<?php
    foreach ($forums as $forum) {
        echo "<tr>\n";
        echo "<td>" . $forum->fname . "</td>";
        echo '<td>
                <input type="number" min="1" max="50" name="in['.$forum->fid.']"
                value="'.$forum->forder.'" required>';
        echo '</td>'."\n";
        echo "</tr>\n";
    }
?>
    </table>
    <br>
    <input type="hidden" name="disp_ord" value="1">
    <input type="submit" value="Submit">
    <input type="button" value="Cancel"
        onClick="window.location.href='?act=admin'"> 
</form>
</div>
<?php
require('inc/footer.php');
exit();
