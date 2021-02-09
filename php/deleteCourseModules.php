<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '1');

//require_once 'export_moodle.php';
require_once 'curl.php';

define('DATABASE', 'moodle_doc_db');
require 'nts_repl_msqli_config.php';



$course_id = $_GET['course_id'];


$domainname = 'https://education.nts.nl'; //paste your domain here
$wstoken = 'd59c0678332d86f0e78e16d523acbe6e'; //here paste your enrol token
$restformat = 'json';