<?php

if(defined('UNAME')) {
    header('location:index.php');
    exit();
}

ob_start();

require('inc/header.php');

$error = '';
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=login">Login</a>
</div>

<?php
if (isset($_POST['username'])) {
    require('inc/csrf_check.php');
    $username = trim($_POST['username']);
    $username = htmlspecialchars($username, ENT_HTML5);
    $password = trim($_POST['password']);
    $password = htmlspecialchars($password, ENT_HTML5);
    if (strlen($username) < 3 || strlen($password) < 6) {
        header('location:index.php');
        exit();
    }else{

        $sql = "SELECT * FROM users WHERE username LIKE '$username'";
        $row = $db->query($sql)->fetch();
        if ($row && password_verify($password, $row->password)) {
            setcookie('username',  $row->username, time() + 30*24*3600);
            setcookie('userid',    $row->uid,      time() + 30*24*3600);
            setcookie('userlevel', $row->ulevel,   time() + 30*24*3600);
            $uid = $row->uid;
            $sql = "UPDATE users SET logged=1 WHERE uid=$uid";
            $db->exec($sql);
            $db = null;
            header('location:index.php');
            exit();
        }else{
            $error = 'Username and Password were not correct<br><br>';
        }
    }
}

ob_end_flush();

?>

<div id="loginform">
    <?php echo $error ?>
    LOGIN
    <form method="post">
        Username <input name="username" required>
        <br>
        Password <input type="password" name="password" required>
        <br><br>
        <?php require('inc/csrf_create.php') ?>
        <input type="submit">&nbsp;&nbsp;
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
    </form>
</div>
<?php
require('inc/footer.php');
exit();
