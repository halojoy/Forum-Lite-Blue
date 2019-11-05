<?php

if (!defined('ULEVEL') || ULEVEL < 2) exit();

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=admin">Admin</a> &#187;
    <a href="?act=newforum">Create New Forum</a>
</div>

<?php
if (isset($_POST['forumname'])) {
    $forumname = trim($_POST['forumname']);
    $descript  = trim($_POST['descript']);

    $sql = "INSERT INTO forums (fname, descript) VALUES (?, ?)";
    $sth = $db->prepare($sql);
    $sth->bindParam(1, $forumname);
    $sth->bindParam(2, $descript);
    $sth->execute();
    $id = $db->lastInsertId();
    $sql = "UPDATE forums SET forder=$id WHERE fid=$id";
    $db->exec($sql);
    $sth = null;
    $db = null;
    echo '<div class="paddin">Forum: "'.
                $forumname.'" was created</div>';
}
?>
<div class="paddin">
    <form method="post">
        New Forum:<br>
        <input name="forumname" required>
        <br>
        Short Description:<br>
        <input name="descript" size="50">
        <br><br>
        <input type="submit">
        <input type="button" value="Cancel"
            onClick="window.location.href='?act=admin'">
    </form>
</div>
<?php
require('inc/footer.php');
exit();
