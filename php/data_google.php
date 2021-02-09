<?php

//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', '1');
define('DATABASE', 'moodle_doc_db');
require 'nts_repl_msqli_config.php';
require_once('curl.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$id = $_GET['id'];

$documents_query = "SELECT doc_name FROM `documents` WHERE id =".$id;
$documents_result = mysqli_query($dbc, $documents_query);
$documents = mysqli_fetch_array($documents_result);

$domainname = 'https://education.nts.nl'; //paste your domain here
$wstoken = 'd59c0678332d86f0e78e16d523acbe6e'; //here paste your enrol token
$restformat = 'json';

$wsfunctionname = 'core_course_create_courses';

$params = [
    'courses' => [ 
        [
            'fullname' => $documents['doc_name'],
            'shortname' => $documents['doc_name'],
            'categoryid' => 1,
            'format' => 'topics',
            'courseformatoptions' => [
                ['name' => 'numsections', 'value' => '0']
            ]
        ]
    ]
];


//header('Content-Type: application/json');
$serverurl = $domainname . "/webservice/rest/server.php?wstoken=" . $wstoken . "&wsfunction=" . $wsfunctionname;

$curl = new curl;
$restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
$resp = $curl->post($serverurl . $restformat, $params);
$coursedata = json_decode($resp);

$course_id = $coursedata[0]->id;

$query = "SELECT * FROM `toc` WHERE doc_id =".$id;
$result = mysqli_query($dbc, $query);

$section_id = 0;
$section_name = '';
$parent_id = 0;
//$counter = 0;
while ($row = mysqli_fetch_assoc($result)) {

    if ($row['parent_id'] != 0) {

        $dataObject = [
            'page_name' => $row['chapter'],
            'section_id' => $section_id,
            'parent_id' => $parent_id,
            'section_name' => $section_name,
            'content' => $row['content'],
            'course_id' => $course_id
        ];

        $curl = new curl;
        $serverurl = $domainname . "/data_content.php?action=3";
        $resp = $curl->post($serverurl, $dataObject);
        $pagedata = json_decode($resp);
//        print_r($pagedata);


        if ($pagedata->is_section) {

            $wsfunctionname = 'core_update_inplace_editable';

            $params = [
                'component' => 'format_topics',
                'itemtype' => 'sectionname',
                'itemid' => $pagedata->section,
                'value' => $section_name,
            ];

            $serverurl = $domainname . "/webservice/rest/server.php?wstoken=" . $wstoken . "&wsfunction=" . $wsfunctionname;

            $curl = new curl;
            $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
            $resp = $curl->post($serverurl . $restformat, $params);
        }
    } else {

        $section_id++;
        $section_name = $row['chapter'];
    }

    $parent_id = $row['parent_id'];

}

echo json_encode(array('response'=>'Exported successfully'));
