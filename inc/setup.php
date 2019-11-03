<?php

if (is_file('data/config.php')) {
    require('data/config.php');
    if (isset($dsn))
        return;
}
if (is_file('tablessqlite.php'))
    exit();
?>
<!DOCTYPE html>
<html>
<head>
    <title>SETUP</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/default.css">
    <link rel="icon" type="image/x-icon" sizes="16x16" href="inc/favicon.ico">
</head>

<body>
<div id="wrapper">
<div class="paddin">
<?php
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $secret = $_POST['secret'];

    $config = <<<CODE
<?php

\$forum_title = '$title';
\$secret_key  = '$secret';

CODE;
    if (!is_dir('data'))
        mkdir('data');
    if (!is_file('data/.htaccess'))
        file_put_contents('data/.htaccess', 'Require all denied'."\n");
    file_put_contents('data/config.php', $config);
    ?>
<form method="post">
    Database:<br><br>
    <select name="database" size="2" required>
        <option value="sqlite">SQLite</option>
        <option value="mysql">MySQL</option>
    </select>
    <br><br>
    <input type="submit">
</form>
<?php
exit();
}

if (isset($_POST['database'])) {
    $database = $_POST['database'];
    if ($database == 'sqlite') {
        echo 'Install SQLite<br><br>';
?>
<form method="post">
    <input type="hidden" name="base" value="sqlite">
    <input type="submit">
</form>
<?php
    }elseif($database == 'mysql') {
        echo 'Install MySQL<br><br>';
?>
<form method="post">
    DB Host:<br>
    <input name="dbhost" value="localhost" required><br><br>
    DB Name:<br>
    <input name="dbname" required><br><br>
    DB User:<br>
    <input name="dbuser" required><br><br>
    DB Pass:<br>
    <input name="dbpass" required><br><br>
    <input type="hidden" name="base" value="mysql">
    <input type="submit">
</form>
<?php
    }
    exit();
}

if (isset($_POST['base'])) {
    $base = $_POST['base'];
    if ($base == 'sqlite') {
        echo 'Install SQLite<br>';
        $dsn = 'sqlite:data/sqlite.db';
        $dbuser = '';
        $dbpass = '';
    }else{
        echo 'Install MySQL<br>';
        extract($_POST);
        $dsn = "mysql:host=$dbhost;dbname=$dbname";
    }
    $config = <<<TEXT

\$dbase = '$base';
\$dsn = '$dsn';
\$dbuser = '$dbuser';
\$dbpass = '$dbpass';

TEXT;
    file_put_contents('data/config.php', $config, FILE_APPEND);
    
    $db = new PDO($dsn, $dbuser, $dbpass);
    if ($base == 'sqlite')
        require('inc/tablessqlite.php');
    else
        require('inc/tablesmysql.php');
    $db = null;
?>
    <h4>SETUP is done</h4>
    Goto <a href="index.php">Home</a><br>
    and Sign Up for <strong>your Admin Account</strong>.
    </div>
    </div>
    </body>
    </html>
<?php
    exit();
}

?>
    <h2>SETUP</h2>
    <form method="post">
        Forum Title:<br>
        <input name="title" value="Forum Lite Blue"><br><br>
        Secret Key:<br>
        <input name="secret" value ="Very Secret"><br><br>
        <input type="submit">
    </form>
</div>
</div>
</body>
</html>
<?php
exit();
