<?php

if (is_file('../data/sqlite.db') || is_file('data/sqlite.db'))
    exit();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $forum_title ?></title>
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
    
    $db = new SQLite3('data/sqlite.db');

    $sql = "CREATE TABLE IF NOT EXISTS forums (
     fid INTEGER PRIMARY KEY,
     fname    TEXT,
     descript TEXT )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS topics (
     tid INTEGER PRIMARY KEY,
     fid INTEGER,
     subject  TEXT,
     userid   INTEGER,
     lasttime INTEGER )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS posts (
     pid INTEGER PRIMARY KEY,
     tid INTEGER,
     message  TEXT,
     userid   INTEGER,
     posttime INTEGER )";
    $db->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS users (
     uid      INTEGER PRIMARY KEY,
     username TEXT, 
     password TEXT, 
     ip       TEXT )";
    $db->exec($sql);

    $db->close();
?>
    SETUP is done.<br><br>
    Goto <a href="index.php">Home</a><br>
    and Sign Up for your admin account.
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
