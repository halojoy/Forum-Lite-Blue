<?php

require('inc/init.php');
if(defined('UNAME')) {
    header('location:index.php');
    exit();
}
session_start();
require('inc/header.php');
?>

<div id="breadcrumb">
    <a href="index.php">Home</a> &#187;
    <a href="signup.php">Sign Up</a>
</div>

<?php
if (isset($_POST['username'])) {
    require('inc/csrf_check.php');
    if (require('inc/captcha_check.php')) {
        echo '<div class="paddin">';
        $db = new SQLite3('data/sqlite.db');
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $sql = "SELECT ip FROM users WHERE ip='$ipaddress'";
        if ($db->querySingle($sql)) {
            $db->close();
            exit( 'You can only have one account.<br><br>
                    Goto startpage: <a href="index.php">Home</a>');
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
            if ($db->querySingle($sql))
                echo 'Username is already taken';
            else{
                $passhash = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (username,password,ip) VALUES (?, ?, ?)";
                $stm = $db->prepare($sql);
                $stm->bindParam(1, $username,  SQLITE3_TEXT);
                $stm->bindParam(2, $passhash,  SQLITE3_TEXT);
                $stm->bindParam(3, $ipaddress, SQLITE3_TEXT);
                $stm->execute();
                $stm->close();
                $db->close();
                echo 'Success.<br>You can now go and login!<br><br>
                Goto startpage: <a href="index.php">Home</a>';
                exit();
            }
        }
        echo '</div>';
        $db->close();
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
