<?php

$act = 'home';
if (isset($_GET['act']))
    $act = $_GET['act'];

switch($act):
    case 'admin':
        require('inc/admin.php');
        break;
    case 'dbadmin':
        header('location: inc/dbadmin.php');
        exit();
        break;
    case 'unban':
        require('inc/unban.php');
        break;
    case 'banuser':
        require('inc/banuser.php');
        break;
    case 'deluser':
        require('inc/deluser.php');
        break;
    case 'admusers':
        require('inc/admusers.php');
        break;
    case 'altlock':
        require('inc/altlock.php');
        break;
    case 'altstick':
        require('inc/altlock.php');
        break;
    case 'doedit':
        require('inc/doedit.php');
        break;
    case 'dodelete':
        require('inc/dodelete.php');
        break;
    case 'admforums':
        require('inc/admforums.php');
        break;
    case 'admtopics':
        require('inc/admtopics.php');
        break;
    case 'admposts':
        require('inc/admposts.php');
        break;
    case 'newforum':
        require('inc/newforum.php');
        break;
    case 'forder':
        require('inc/forumorder.php');
        break;
    case 'newtopic':
        require('inc/newtopic.php');
        break;
    case 'newpost':
        require('inc/newpost.php');
        break;
    case 'topics':
        require('inc/topics.php');
        break;
    case 'posts':
        require('inc/posts.php');
        break;
    case 'login':
        require('inc/login.php');
        break;
    case 'logout':
        require('inc/logout.php');
        break;
    case 'signup':
        require('inc/signup.php');
        break;
    case 'home':
    default:
endswitch;
