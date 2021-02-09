<?php

ini_set('display_errors', '1');

/* Default time zone ,to be able to send mail */
date_default_timezone_set('Africa/Nairobi');


$dbc = mysqli_connect('localhost', 'projectuser', 'wgnd8b', 'nts_site');

if (mysqli_connect_errno()) {
    echo 'Could not connect to MySQL: ' . mysqli_connect_error();
	exit();
}

// session_start();