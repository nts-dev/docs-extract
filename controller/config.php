<?php

ini_set('display_errors', '1');

/* Default time zone ,to be able to send mail */
date_default_timezone_set('UTC');

require_once '../../includes.php';

$dbc = mysqli_connect(Boot::DBHOST, Boot::DBUSER, Boot::DBPASS, Boot::DBNAME);

if (mysqli_connect_errno()) {
    echo 'Could not connect to MySQL: ' . mysqli_connect_error();
	exit();
}

// session_start();