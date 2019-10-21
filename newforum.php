<?php

require('inc/init.php');
if (!defined('UID') || UID != 1) {
    header('location:index.php');
    exit();
}

require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="newforum.php">Create New Forum</a>
</div>

<?php
if (isset($_POST['forumname'])) {
    $forumname = trim($_POST['forumname']);
    $descript  = trim($_POST['descript']);
    $db = new SQLite3('data/sqlite.db');
    $sql = "INSERT INTO forums (fname, descript) VALUES (?, ?)";
    $stm = $db->prepare($sql);
    $stm->bindParam(1, $forumname, SQLITE3_TEXT);
    $stm->bindParam(2, $descript,  SQLITE3_TEXT);
    $stm->execute();
    $stm->close();
    $db->close();
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
        <input type="submit">&nbsp;&nbsp;
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
    </form>
</div>
<?php
require('inc/footer.php');
