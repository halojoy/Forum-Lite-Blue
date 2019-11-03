<?php

if(defined('UNAME')) {
    header('location:index.php');
    exit();
}
require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="?act=signup">Sign Up</a>
</div>

<?php
if (isset($_POST['username'])) {
    require('inc/csrf_check.php');
    if (require('inc/captcha_check.php')) {
        echo '<div class="paddin">';

        $ipaddress = require('inc/getip.php');
        if ($ipaddress != 'UNKNOWN') {
            $sql = "SELECT ip FROM users WHERE ip='$ipaddress'";
            if ($db->query($sql)->fetchColumn()) {
                $db = null;
                exit( 'You can only have one account.<br><br>
                        Goto startpage: <a href="index.php">Home</a>');
            }
            $sql = "SELECT ip FROM banned WHERE ip='$ipaddress'";
            if ($db->query($sql)->fetchColumn()) {
                $db = null;
                exit('Sorry. You are banned');
            }
        }

        $username = trim($_POST['username']);
        $username = htmlspecialchars($username, ENT_HTML5);
        $password = trim($_POST['password']);
        $password = htmlspecialchars($password, ENT_HTML5);
        if (strlen($username) < 3 || strlen($password) < 6)
            echo 'Username should be at least 3 chars.<br>
                  Password should be at least 6 chars.';
        else{
            $sql = "SELECT username FROM users WHERE username LIKE '$username'";
            if ($db->query($sql)->fetchColumn())
                echo 'Username is already taken';
            else{
                $passhash = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (username,password,ip) VALUES (?, ?, ?)";
                $sth = $db->prepare($sql);
                $sth->bindParam(1, $username);
                $sth->bindParam(2, $passhash);
                $sth->bindParam(3, $ipaddress);
                $sth->execute();
                $sth = null;
                $db  = null;
                echo 'Success.<br>You can now go and login!<br><br>
                Goto startpage: <a href="index.php">Home</a>';
                exit();
            }
        }
        echo '</div>';
        $db = null;
    }
}
?>
<div id="loginform">
    SIGN UP
    <form method="post">
        Username <input name="username" required>
        <br>
        Password <input type="password" name="password" required>
        <br><br>
        <?php require('inc/csrf_create.php') ?>
        <img src="inc/captcha_img.php">
        <br>
        <?php require('inc/captcha_input.php') ?>
        <br>
        <input type="submit">&nbsp;&nbsp;
        <input type="button" value="Cancel"
            onClick="window.location.href='index.php'">
    </form>
</div>
<?php
require('inc/footer.php');
exit();
