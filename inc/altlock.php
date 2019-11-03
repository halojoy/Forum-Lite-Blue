<?php

if (!isset($_GET['tid']))
    exit();
else
    $tid = $_GET['tid'];

if ($act == 'altlock') {
    $sql = "SELECT locked FROM topics WHERE tid=$tid";
    $oldlock = $db->query($sql)->fetchColumn();
    $newlock = 1 - $oldlock;
    $sql = "UPDATE topics SET locked=$newlock WHERE tid=$tid";
    $db->exec($sql);
}

if ($act == 'altstick') {
    $sql = "SELECT sticky FROM topics WHERE tid=$tid";
    $oldstick = $db->query($sql)->fetchColumn();
    $newstick = 1 - $oldstick;
    $sql = "UPDATE topics SET sticky=$newstick WHERE tid=$tid";
    $db->exec($sql);
}

$sql = "SELECT fid FROM topics WHERE tid=$tid";
$fid = $db->query($sql)->fetchColumn();
$db = null;
header('location: ?act=admtopics&fid='.$fid);
exit();
    