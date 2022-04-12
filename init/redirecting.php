<?php session_start();

if (!$_SESSION['loggeduser']) {
    require('Errorpage.php');
}

