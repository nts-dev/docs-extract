<?php

ini_set('display_errors', '0');
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', 0);
include '../../config.php';
include 'curl.php';
require_once '../vendor/autoload.php';
//include "documents.php";
define('IMPORTZIP', 1);
define('IMPORTURL', 2);
define('UPLOADFOLDER', 3);
define('UPLOADJSON', 4);
libxml_use_internal_errors(true);
$headings = array();
$upperCss = "";
$lowerCss = "";
$docName = "";
$sortId = 0;
$parent_id = 0;
$parent_id1 = 0;
$parent_id2 = 0;
$documentId = 0;
$updatekey = -1;
$insertRecords = [];
$responses = [];
$firstDelimiters = '';
$filename = "";
$counter_l1 = 0;
$counter_l2 = 0;
$counter_l3 = 0;
$counter_l4 = 0;
$qid = '';
$url = '';
$server = 0;
$qid1 = 0;
$qsort = 0;
$checkSections = 0;
$details = '';
$contentPerChapter = '';
$strContent = '';
$fileCounter = 0;
$privateIps = [];
$hasPrivateIP = false;
$delimiters = [];
$links = '<a,</a>';
$userCommands_1 = "<%,%>";
$userCommands = "&lt;%,%&gt;";
$delimiters[] = $links;
$delimiters[] = $userCommands;
$php_id = 0;
$php_name ="";
$php_action = 0;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_NUMBER_INT);
//$classObj = new Files(); '&lt;%') !== false && strpos($content, '%&gt;') !== false) {

//echo  $classObj->download("mp3");
//exit;
switch ($action) {
    case IMPORTZIP:


        try {
            $reimport = filter_input(INPUT_GET, 'reimport');
            $doc_id = filter_input(INPUT_GET, 'doc_id');

            $server = filter_input(INPUT_GET, 'server', FILTER_SANITIZE_NUMBER_INT);
            $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);

            if ($_FILES["file"]["name"]) {
                $filename = $_FILES["file"]["name"];
                $source = $_FILES["file"]["tmp_name"];
                $type = $_FILES["file"]["type"];

                $name = explode(".", $filename);
                $docName = $name[0];

                $accepted_types = array('application/zip', 'text/html', 'application/x-zip-compressed',
                    'multipart/x-zip', 'application/x-compressed');
                foreach ($accepted_types as $mime_type) {
                    if ($mime_type == $type) {
                        $okay = true;
                        break;
                    }
                }

                $path_html = __DIR__ . '/';
                $filenoext = basename($filename, '.zip');
                $filenoext = basename($filenoext, '.ZIP');
                $filenoext = basename($filenoext, '.doc');
                // $path = str_replace("Google_docs_extract\controller", "googleDocMedia", $path_html);

                $path = $_SERVER["DOCUMENT_ROOT"] . "/CourseFiles/documentFiles/";

                if (!file_exists($path)) {
                    if (!mkdir($path, 0774, true) && !is_dir($path)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                    }
                }
                $myDir = $path . $filenoext; // target directory
                $myFile = $path . $filename; // target zip file
                $dir = str_replace('.htm', '', $myFile);

                if (strpos($myFile, '.htm') !== false || strpos($myFile, '.zip') !== false) {
                    if (move_uploaded_file($source, $myFile)) {

                        if (strpos($myFile, '.htm') !== false) {

                            readGoogleDocHtml($myDir, $filenoext, true);

                            if (file_exists($dir)) {
                                xrmdirs($dir);
                            }
                        } else {
                            $zip = new ZipArchive();
                            $x = $zip->open($myFile); // open the zip file to extract
                            if ($x === true) {
                                $zip->extractTo($myDir); // place in the directory with same name
                                readGoogleDocZip($myDir, $filenoext, true);
                                $zip->close();
                                unlink($myFile);
                            }
                        }
                        $myMsg = "Your .zip file uploaded and unziped.";
                        $updateMsg = "Course Updated.";

                        print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "', extra: {info: '$myMsg '}}");
                    } else {
                        $myMsg = "There was a problem with the upload.";
                        header("Content-Type: text/json");
                        print_r("{state: false, name:" . $filename . "', extra: {info: '$myMsg '}}");
                    }
                } else {
                    $myMsg = "Upload a valid file i.e .htm or zip file!.";
                    header("Content-Type: text/json");
                    print_r("{state: false, name:" . $filename . "', extra: {info: '$myMsg '}}");
                }
                if ($reimport == 1) {
                    deleteNonUpdate();
                    bDelete();
                    bChanged();
                    bInsert();
                    bUpdate();
                }
            }

            // echo json_encode($responses);
        } catch (Exception $e) {
            $response = [
                'response' => false, 'text' => $e->getMessage()
            ];
            $responses[] = $response;
            echo json_encode($responses);
        }

        break;

    case UPLOADJSON:

        try {
            if ($_FILES["file"]["name"]) {
                $filename = $_FILES["file"]["name"];
                $source = $_FILES["file"]["tmp_name"];
                $type = $_FILES["file"]["type"];

//                $name = explode(".", $filename);
//                $fileName = $name[0];

                $accepted_types = array('application/json');
                foreach ($accepted_types as $mime_type) {
                    if ($mime_type == $type) {
                        $okay = true;
                        break;
                    }
                }

                $path_html = basename(__DIR__) . '/';
                $filenoext = basename($filename, '.json');
               // $path =  basename(__DIR__) ;
                $path = $_SERVER["DOCUMENT_ROOT"] . "/CourseFiles/Keys/";

                if (!file_exists($path)) {
                    if (!mkdir($path, 0774, true) && !is_dir($path)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                    }
                }

                //$myDir = $path . $filenoext; // target directory
                $myFile = $path . $filename; // target zip file
                $dir = str_replace('.json', '', $myFile);

                if (strpos($myFile, '.json') !== false ) {
                    if (move_uploaded_file($source, $myFile)) {
                        $myMsg = "Your .json file uploaded successfully.";
                        $updateMsg = "Course Updated.";

                        insertKeys($filename,$myFile);

                        print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "', extra: {info: '$myMsg '}}");
                    } else {
                        $myMsg = "There was a problem with the upload.";
                        header("Content-Type: text/json");
                        print_r("{state: false, name:" . $filename . "', extra: {info: '$myMsg '}}");
                    }
                } else {
                    $myMsg = "Upload a valid file i.e .json file!.";
                    header("Content-Type: text/json");
                    print_r("{state: false, name:" . $filename . "', extra: {info: '$myMsg '}}");
                }

            }

            // echo json_encode($responses);
        } catch (Exception $e) {
            $response = [
                'response' => false, 'text' => $e->getMessage()
            ];
            $responses[] = $response;
            echo json_encode($responses);
        }

        break;
    case IMPORTURL:

        try {
            $reimport = filter_input(INPUT_POST, 'reimport');
            $doc_id = filter_input(INPUT_POST, 'doc_id');
            $Key = filter_input(INPUT_POST, 'key');
            $fileId = filter_input(INPUT_POST, 'url');
            $details = filter_input(INPUT_POST, 'details');

            $server = filter_input(INPUT_POST, 'server', FILTER_SANITIZE_NUMBER_INT);
            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
            $url = $fileId;
            $fileId = explode("d/", $fileId);

            if (strpos($fileId[0], 'docs.google.com/document') === false) {

                echo json_encode(array('response' => false, 'text' => 'Enter a valid document url/link and try again!'));
                break;
            }

            $fileId = $fileId[1];
            $fileId = explode("/", $fileId);
            $fileId = $fileId[0];
            $client = getClient($Key);

            $docName = getDocumentName($client, $fileId);
            if ($docName != "")
                $content = getContent($client, $fileId);

            if ($content) {
                $check = readGoogleDocUrl($content);
                if (!$checkSections) {
                    $response = [
                        'response' => true, 'server' => $server, 'text' => 'Your document has been extracted successfully!'
                    ];
                    $responses[] = $response;
                    echo json_encode($responses);
                }
                // echo json_encode(array('response' => true, 'server' => $server, 'text' => 'Your document has been extracted successfully!'));
                if ($reimport == 1) {
                    if (deleteNonUpdate())
                        if (bChanged())
                            if (bInsert())
                                if (bUpdate())
                                    bDelete();

                }

            }

        } catch (Exception $e) {
            $response = [
                'response' => false, 'text' => $e->getMessage()
                // 'response' => true, 'server' => $server, 'text' => 'Your document has been extracted successfully!'
            ];
            $responses[] = $response;
       echo json_encode($responses);
            //echo json_encode(array('response' => false, 'text' => $e->getMessage()));
        }
        break;

    case  UPLOADFOLDER:
        $folderName = filter_input(INPUT_GET, 'folder');
        $folder = $_SERVER["DOCUMENT_ROOT"] . "/CourseFiles/documentFiles/" . $folderName . "/";
        if (!file_exists($folder)) {
            if (!mkdir($folder, 0774, true) && !is_dir($folder)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $folder));
            }
        }
        if ($_FILES["file"]["name"]) {
            $filename = $_FILES["file"]["name"];
            $source = $_FILES["file"]["tmp_name"];
            $type = $_FILES["file"]["type"];
            $name = explode(".", $filename);
            $docName = $name[0];
            $myFile = $folder . $filename;

            if (!file_exists($myFile)) {
                if (move_uploaded_file($source, $myFile)) {
                    $myMsg = "Your .zip file uploaded and unziped.";
                    $updateMsg = "Course Updated.";
                    print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "', extra: {info: '$myMsg '}}");

                } else {
                    $myMsg = "There was a problem with the upload.";
                    header("Content-Type: text/json");
                    print_r("{state: false, name:" . $filename . "', extra: {info: '$myMsg '}}");
                }
            } else {
                $myMsg = "Your .zip file uploaded and unziped.";
                $updateMsg = "Course Updated.";
                print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "', extra: {info: '$myMsg '}}");
            }
        }
        break;

    default:
        break;
}
function getClient($Key)
{
    try {
        $client = new Google_Client();
        $key =$_SERVER["DOCUMENT_ROOT"] . "/CourseFiles/Keys/".$Key;

        $client->setAuthConfig($key);
        $client->addScope(Google_Service_Docs::DOCUMENTS);
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->addScope(Google_Service_Drive::DRIVE_READONLY);
        $client->setConfig('CURLOPT_CONNECTTIMEOUT', 100);
        $client->setConfig('CURLOPT_TIMEOUT', 1000);
    } catch (Exception  $e) {
        $response = $e->getCode();
        if ($response == 404)
            echo json_encode(
                array('response' => false,
                    'text' => 'The link you entered is invalid or has some typo mistakes,check the link and try again !'));
        else {
//            echo json_encode(array('response' => false,
//                'text' => 'No access has been Granted to the service account!!
//                 Please share the document with ntsdocuments@extractdocument.iam.gserviceaccount.com, for the program to read and try again!'));

            $response = [
                'response' => false, 'text' => $e->getMessage()
            ];
            $responses[] = $response;
            echo json_encode($responses);
        }
    }
    return $client;
}
function insertKeys($name,$myFile){
    global $dbc;
    $query = 'INSERT INTO authkeys (name,path) VALUES ("' . $name . '","' . $myFile . '")
    ON DUPLICATE KEY UPDATE name=values(name)';

    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

}


function insertPermission($service, $fileId, $type, $role)
{
    $newPermission = new Google_Service_Drive_Permission();
    $newPermission->setType($type);
    $newPermission->setRole($role);
    try {
        return $service->permissions->create($fileId, $newPermission);;
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
    return NULL;
}

//get content
function getContent($client, $fileId)
{
    $driveService = new Google_Service_Drive($client);
    $response = $driveService->files->export($fileId, 'text/html', array(
        'alt' => 'media'));
    return $response->getBody()->getContents();
}

//get document name
function getDocumentName($client, $fileId)
{
    $service = new Google_Service_Docs($client);
    $doc = $service->documents->get($fileId);
    return $doc->getTitle();

}

function readUrlHeaders($contents)
{

    global $headings;
    $heading_arrays = array('h1,/h1', 'h2,/h2', 'h3,/h3', 'h4,/h4', 'h5,/h5', 'h6,/h6');

    foreach ($heading_arrays as $heading_array) {

        getHeadings($contents, $heading_array, '<', '>');

    }
    sort($headings, SORT_NATURAL | SORT_FLAG_CASE);

    return cleanArray($headings, $contents);
}

function cleanArray($headings, $contents)
{
    $headline = [];
    foreach ($headings as $head) {
        $startDelimiters1 = explode("<=>", $head);
        $firstDelimiter = $startDelimiters1[1];
        $firstDelimiter = strip_tags($firstDelimiter);
        $firstDelimiter = trim($firstDelimiter);
        $firstDelimiter = str_replace('&nbsp;', '', $firstDelimiter);
        $firstDelimiter = preg_replace('/[^A-Za-z0-9\-]/', '', $firstDelimiter);
        if ($firstDelimiter != '') {
            $headline[] = $head;
        }

    }
//    echo "<pre>";
//    print_r($headline);
//    exit;
    return readContents($headline, $contents);
}

//replace links with visible videos/audios
function getReplaceLinks($str, $delimiters, $isUser)
{
    //identify video/audio/youtube by their extension

    global $hasPrivateIP, $privateIps;
    $mp4 = array();
    $mp3 = array();
    $mp4[] = '.mp4';
    $mp4[] = '.MP4';
    $mp4[] = '.MKV';
    $mp4[] = '.mkv';
    $mp4[] = '.AVI';
    $mp4[] = '.avi';
    $mp4[] = '.MOV';
    $mp4[] = '.mov';
    $mp3 [] = '.WAV';
    $mp3 [] = '.wav';
    $mp3 [] = '.AIFF';
    $mp3 [] = '.aiff';
    $mp3 [] = '.AAC';
    $mp3 [] = '.aac';
    $mp3 [] = '.OGG';
    $mp3 [] = '.ogg';
    $mp3 [] = '.WMA';
    $mp3 [] = '.wma';
    $mp3 [] = '.MP3';
    $mp3 [] = '.mp3';
    $youtube = '';
    $dhtmxFormat = '';
    if ($isUser) {
        // $mp4 = '001';
        // $mp3 = '003';
        $youtube = '002';
    } else {
        $youtube = 'watch?v=';
        $youtube1 = 'youtu.be';
        $dhtmxFormat = '/play?id=';
        $dhtmxFormats = '/play/?id=';
    }
    foreach ($delimiters as $delimiter) {
        $Delimiter = explode(",", $delimiter);
        $startDelimiter = $Delimiter[0];
        $endDelimiter = $Delimiter[1];
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $replace = $startDelimiter . substr($str, $contentStart, $contentEnd - $contentStart) . $endDelimiter;
            $str = replaceLinks($replace, $str, $mp4, $mp3, $youtube, $isUser, $dhtmxFormat, $dhtmxFormats);
            $startFrom = $contentEnd + $endDelimiterLength;
        }
        if ($hasPrivateIP) {

            $response = [
                'response' => true, 'hasPrivateIP' => true, 'urls' => implode(",", $privateIps)
            ];
            $responses[] = $response;

        }
    }
    return $str;
}


function replaceLinks($replace, $str, $mp4, $mp3, $youtube, $isUser, $dhtmxFormat, $dhtmxFormats)
{
    $youtubeDelimiter = '';
    if ($isUser) {
        $youtubeDelimiter = '<%002';
    }
   // $pattern = '/(^127\.)|(^192\.168\.)|(^10\.)|(^172\.1[6-9]\.)|(^172\.2[0-9]\.)|(^172\.3[0-1]\.)|(^::1$)|(^[fF][cCdD])/';
    if (filter_var(strip_tags($replace), FILTER_VALIDATE_URL)) {
        if (!empty($dhtmxFormat)) {
            $str = checkDhtmlxFormat($dhtmxFormat,  $replace, $str);
        }
        if (!empty($dhtmxFormats)) {
            $str = checkDhtmlxFormat($dhtmxFormats, $replace, $str);
        }
        if (checkMp4Format($mp4, strip_tags($replace))) {
            $str = replaceMp4Format($replace, $mp4, $str);
        } else if (checkMp3Format($mp3, strip_tags($replace))) {
            $str = replaceMp3Format($replace, $mp3, $str);
        }
        $str = replaceYoutubeFiles($replace, $youtube, $youtubeDelimiter, $str);
    }
    $str = replaceUserCommandFiles($replace, $str);
    return $str;
}

function checkDhtmlxFormat($dhtmxFormat, $replace, $str)
{
    global $hasPrivateIP;
    $pattern = '/(^127\.)|(^192\.168\.)|(^10\.)|(^172\.1[6-9]\.)|(^172\.2[0-9]\.)|(^172\.3[0-1]\.)|(^::1$)|(^[fF][cCdD])/';
    if (preg_match($pattern, strip_tags($replace)) || strpos(strip_tags($replace), 'localhost') !== false) {
        $privateIps[] = strip_tags($replace);
        $hasPrivateIP = true;
    }
    if (strpos(strip_tags($replace), $dhtmxFormat) !== false && (preg_match($pattern, strip_tags($replace))||strpos(strip_tags($replace), "localhost") !== false )) {
        $str = checkRelativePath($str, strip_tags($replace));
    } else if (strpos(strip_tags($replace), $dhtmxFormat) !== false) {
        $str = checkAbsolutePath(strip_tags($replace), $str);

    }
    return $str;
}


function replaceYoutubeFiles($replace, $youtube, $youtubeDelimiter, $str)
{
    if (strpos($replace, $youtube) !== false) {
        $embededVideo = str_replace("www.youtube.com/watch?v=", "www.youtube-nocookie.com/embed/", strip_tags($replace));
        $embededVideo = explode("&amp;", $embededVideo);
        $embededVideo = $embededVideo[0];
        $replacement = "<iframe src='" . $embededVideo . "' width='560' height='315'  allow='autoplay; encrypted-media' allowfullscreen'></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
        $str = str_replace($youtubeDelimiter . $replace, $replacement, $str);
    } else if (strpos($replace, 'youtu.be') !== false) {
        $embededVideo = str_replace("youtu.be", "www.youtube-nocookie.com/embed", strip_tags($replace));
        $embededVideo = explode("&amp;", $embededVideo);
        $embededVideo = $embededVideo[0];
        $replacement = "<iframe src='" . $embededVideo . "' width='560' height='315' frameBorder='0' allow='autoplay; encrypted-media' allowfullscreen'></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
        $str = str_replace($youtubeDelimiter . $replace, $replacement, $str);
    } else if (strpos($replace, 'youtube.com/embed') !== false) {
        $replacement = "<iframe src='" . strip_tags($replace) . "' width='560' height='315' frameBorder='0' allow='autoplay; encrypted-media' allowfullscreen'></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
        $str = str_replace(strip_tags($replace), $replacement, $str);
    }
    return $str;
}

function replaceUserCommandFiles($replace, $str)
{
    if (strpos($replace, 'play:video') !== false) {
        $harshCode = explode("=", strip_tags($replace));
        if (isset($harshCode[1])) {
            $harshCode = $harshCode[1];
            $harshCode = str_replace('%&gt;', '', $harshCode);
            $replacement = "<iframe src='/nts-programs/nts-video/play?id=" . $harshCode . "' width='560' height='315' frameBorder='0' allow='autoplay; encrypted-media' allowfullscreen'></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
            $str = str_replace(strip_tags($replace), $replacement, $str);
        }
    }
    if (strpos($replace, 'play:audio') !== false) {
        $harshCode = explode("=", strip_tags($replace));
        if (isset($harshCode[1])) {
            $harshCode = $harshCode[1];
            $harshCode = str_replace('%&gt;', '', $harshCode);
            $replacement = "<iframe src='/nts-programs/nts-video/play?id=" . $harshCode . "' width='400' height='200' frameBorder='0' allow='autoplay; encrypted-media' allowfullscreen'></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
            $str = str_replace(strip_tags($replace), $replacement, $str);
        }
    }
    return $str;
}

function replaceMp3Format($replace, $mp3, $str)
{
    $link = downloadAudio(strip_tags($replace), $mp3);
    if (!empty($link)) {
        $replacement = "<a href='" . $link . "'>Audio Here</a>";
        $str = str_replace($replace, $replacement, $str) . ".";
    }
    return $str;
}

function replaceMp4Format($replace, $mp4, $str)
{
    $videoLink = downloadVideo(strip_tags($replace), $mp4);
    if (!empty($videoLink)) {
        $replacement = "<a href='" . $videoLink . "'>Video Here</a>";
        $str = str_replace($replace, $replacement, $str) . ".";
    }
    return $str;
}

function checkRelativePath($str, $replace)
{
    $path = parse_url(strip_tags($replace), PHP_URL_PATH);
    $query = parse_url(strip_tags($replace), PHP_URL_QUERY);
    $url = $path . "?" . $query;
    $replacement = "<iframe src='" . $url . "' width='500' height='300' frameBorder='0' allowfullscreen='true'  ></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
    $str = str_replace($replace, $replacement, $str);

    return $str;
}

function checkAbsolutePath($replace, $str)
{
    $replacement = "<iframe src='" . $replace . "' width='500' height='300' frameBorder='0' allowfullscreen='true'  ></iframe></span> <p class='c2'><span ></span></p><p ><span ></span></p></p><p ><span ></p>";
    return str_replace($replace, $replacement, $str);
}

function checkMp4Format($mp4, $link)
{
    foreach ($mp4 as $format) {
        return substr_compare($link, $format, -strlen($format)) === 0;
    }
    return false;
}

function checkMp3Format($mp3, $link)
{

    foreach ($mp3 as $format) {
        if (preg_match('/' . $format . '/', $link))
            return true;
        //return substr_compare($link, $format, -strlen($format)) === 0;
    }
    return false;
}

function readGoogleDocUrl($content)
{
    $contentsWithVideoAudio = '';
    global $docName, $strContent, $delimiters;

    $contentsWithVideoAudio = getReplaceLinks($content, $delimiters, false);

    $contentsWithVideoAudio = str_replace('&lt;%001', '', $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;%002", "", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;%003", "", $contentsWithVideoAudio);

    //remove closing user delimiters
    $contentsWithVideoAudio = str_replace("%&gt;", "", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;iframe", "<iframe", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("/iframe&gt;", "/iframe>", $contentsWithVideoAudio);

    $imagesArray = getImages($contentsWithVideoAudio);
    $strContent = $contentsWithVideoAudio;
    loopImagesdownload($imagesArray, $docName);
}

function loopImagesdownload($imagesArray, $docName)
{
    global $strContent, $reimport;
    $path = $_SERVER["DOCUMENT_ROOT"] . "/CourseFiles/documentFiles/";
    if (!file_exists($path)) {
        if (!mkdir($path, 0774, true) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }
    $docFolder = $path . $docName . "/images";
//    if ($reimport) {
//        if (file_exists($docFolder)) {
//            xrmdir($docFolder);
//        }
//    }
    if (!file_exists($docFolder)) {
        if (!mkdir($docFolder, 0774, true) && !is_dir($docFolder)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $docFolder));
        }
    }

    foreach ($imagesArray as $image) {
        $name = substr($image, -7);
        $dir = "/CourseFiles/documentFiles/" . $docName . "/images/" . $name . ".png";
        if ($image) {
            $filename = $docFolder . "/" . $name . ".png";
            if (!file_exists($filename))
                downloadImages($image, $filename, $name);
            else
                $strContent = str_replace($image, $dir, $strContent);
        }
    }
    readUrlHeaders($strContent);
}

function getImages($content)
{
    $doc = new DOMDocument();
    $doc->loadHTML($content);
    $imgElements = $doc->getElementsByTagName('img');
    $images = array();
    for ($i = 0; $i < $imgElements->length; $i++) {
        $images[] = $imgElements->item($i)->getAttribute('src');
    }
    return $images;
}

function downloadImages($url, $image, $name)
{
    global $strContent, $docName;
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $content = file_get_contents($url, false, $context);
    $dir = "/CourseFiles/documentFiles/" . $docName . "/images/" . $name . ".png";
    $fp = fopen($image, "w");
    fwrite($fp, $content);
    fclose($fp);
    $strContent = str_replace($url, $dir, $strContent);
}

function makedir($docname, $fileType)
{
    global $reimport;
    $path = $_SERVER["DOCUMENT_ROOT"] . "/CourseFiles/documentFiles/";
    if (!file_exists($path)) {
        if (!mkdir($path, 0777, true) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }
    $docFolder = $path . $docname . "/" . $fileType;
    if ($reimport) {
        if (file_exists($docFolder)) {
            xrmdirs($docFolder);
        }
    }
    if (!file_exists($docFolder)) {
        if (!mkdir($docFolder, 0777, true) && !is_dir($docFolder)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $docFolder));
        }
    }
    return $docFolder;
}

function downloadAudio($url, $mp3)
{
    global $docName;
    //global $reimport;
    $filename = explode('/', $url);
    $filename = end($filename);
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $url = str_replace(" ", "%20", $url);

    $localUrl = "../../CourseFiles/documentFiles/" . $docName . "/audio/" . $filename;
    if (!file_exists($localUrl)) {
        $docFolder = makedir($docName, 'audio');
        $content = file_get_contents($url, false, $context);
        if (file_exists($docFolder)) {
            $file = $docFolder . "/" . $filename;
            if (!file_exists($file)) {
                $fp = fopen($docFolder . "/" . $filename, "w+");
                fwrite($fp, $content);
                fclose($fp);

            }
        }

    }

    return $localUrl;
}

function downloadVideo($url, $mp4)
{


    global $docName;
    $filename = explode('/', $url);
    $filename = end($filename);
    $opts = array('http' => array('header' => "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"));
    $context = stream_context_create($opts);
    $url = str_replace(" ", "%20", $url);
    $localUrl = "../../CourseFiles/documentFiles/" . $docName . "/video/" . $filename;

    if (!file_exists($localUrl)) {
        $content = file_get_contents($url, false, $context);
        $docFolder = makedir($docName, 'video');
        if (file_exists($docFolder)) {
            $file = $docFolder . "/" . $filename;
            if (!file_exists($file)) {

                if (($fp = fopen($file, "w+")) !== false) {
                    if (is_resource($fp)) {
                        fwrite($fp, $content);
                        fclose($fp);
                    }
                }
                if (!file_exists($file)) {
                    return false;
                }
            }
        }


    }
    return $localUrl;


}

function xrmdirs($dir)
{
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            xrmdirs($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}

function readGoogleDocHtml($path, $docFolder, $check)
{
    global $delimiters;
    $filename = explode(".", $docFolder);
    $filename = $filename[0];
    $filename = str_replace(' ', "%20", $filename);
    $contents = file_get_contents($path);

    if (strpos($contents, $filename . "_files") !== false) {
        $contents = str_replace($filename . "_files", "/CourseFiles/documentFiles/" . $filename, $contents);
        $response = [
            'response' => "uploadFiles",
            'text' => "Upload files"
        ];
        $responses[] = $response;
    }
    // setting delimiters for links
    $startDelimiter = '<a';
    $endDelimiter = '</a>';
    $contentsWithVideoAudio = getReplaceLinks($contents, $delimiters, false);
    //remove opening user delimiters
    $contentsWithVideoAudio = str_replace('&lt;%001', '', $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;%002", "", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;%003", "", $contentsWithVideoAudio);
    //remove closing user delimiters
    $contentsWithVideoAudio = str_replace("&lt;iframe", "<iframe", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("/iframe&gt;", "/iframe>", $contentsWithVideoAudio);
    if ($check) {
        readHeaders($contentsWithVideoAudio);
    }


}

function readGoogleDocZip($path, $docFolder, $check)
{
    global $delimiters;
    $contentsWithVideoAudio = '';
    $content = "";
    $files = glob($path . '/*html');
    $file = glob($path . '/*htm');

    if ($files) {
        $contents = file_get_contents($files[0]);
        $content = str_replace("images/image", "/CourseFiles/documentFiles/" . $docFolder . "/images/image", $contents);
    } else if ($file) {
        $contents = file_get_contents($file[0]);
        $file = explode("/", $file[0]);
        $file = explode(".", end($file));
        $file = $file[0];
        $file = str_replace(' ', "%20", $file);
        if (strpos($contents, $file . "_files") !== false) {
            $content = str_replace($file . "_files", "/CourseFiles/documentFiles/" . $docFolder . "/" . $file . "_files", $contents);
            $response = ['response' => "uploadFiles", 'text' => "Upload files"];
            $responses[] = $response;
        }


    }

    // setting delimiters for links
    // $delimiters="<"
    $contentsWithVideoAudio = getReplaceLinks($content, $delimiters, false);
    //  }

    //remove opening user delimiters
    $contentsWithVideoAudio = str_replace('&lt;%001', '', $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;%002", "", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("&lt;%003", "", $contentsWithVideoAudio);

    //remove closing user delimiters
    $contentsWithVideoAudio = str_replace("&lt;iframe", "<iframe", $contentsWithVideoAudio);
    $contentsWithVideoAudio = str_replace("/iframe&gt;", "/iframe>", $contentsWithVideoAudio);

    if ($check) {
        // readHeaders($contentsWithVideoAudio);
        readUrlHeaders($contentsWithVideoAudio);
    }


}

function readHeaders($contents)
{
    global $headings;
    $heading_arrays = array('<h1,</h1>', '<h2,</h2>', '<h3,</h3>', '<h4,</h4>', '<h5,</h5>', '<h6,</h6>');


    foreach ($heading_arrays as $heading_array) {

        getHeadings($contents, $heading_array, '', '');


    }
    sort($headings, SORT_NATURAL | SORT_FLAG_CASE);

    cleanArray($headings, $contents);


}

function readContents($headings, $content)
{
    global $upperCss;
    global $lowerCss;
    global $firstDelimiters;


    $Delimiter1s = $headings[0];

    $startDelimiters1s = explode("<h1", $Delimiter1s);

    $firstDelimiters = "<h1" . $startDelimiters1s[1];

    $styling = explode('</head>', $content);

    $upperCss = $styling[0] . '</head>';
    $bodyContent = [];

    $arraySize = count($headings);
    $count = 0;
    while ($count < $arraySize - 1) {


        $Delimiter1 = $headings[$count];
        $startDelimiters1 = explode("<=>", $Delimiter1);
        $firstDelimiter = $startDelimiters1[1];


        $Delimiter2 = $headings[$count + 1];
        $startDelimiters2 = explode("<=>", $Delimiter2);
        $secondDelimiter = $startDelimiters2[1];

        $HeadingContent = new stdClass;
        $HeadingContent->heading = $firstDelimiter;
        $HeadingContent->content = $firstDelimiter . getContents($content, $firstDelimiter, $secondDelimiter);


        $bodyContent[] = $HeadingContent;
        $count++;

    }

    $Delimiter3 = end($headings);
    $startDelimiters3 = explode("<=>", $Delimiter3);
    $firstDelimiter3 = $startDelimiters3[1];

    $lastString = explode($firstDelimiter3, $content);
    $lastString2 = explode('</body>', $lastString[1]);
    $bodyContent[$firstDelimiter3] = $lastString2[0];

    $HeadingContent = new stdClass;
    $HeadingContent->heading = $firstDelimiter3;
    $HeadingContent->content = $firstDelimiter3 . $lastString2[0];

    $bodyContent[] = $HeadingContent;

    $lowerCss = '<div>
   
</div>
</body>

</html>';
//   echo "<pre>";
//   print_r($bodyContent);
//   exit;

    return getHeadingsWithContents($bodyContent, $content);


}


function bDelete()
{
    global $dbc;
    global $doc_id;
    $inserts = [];
    $levels = [];
    $ids_toc = [];
    $ids_archivec = [];
    $delete_archive = "UPDATE  archived_toc a SET a.bDelete =1
WHERE not exists (select * from toc b WHERE b.chapter_id = a.chapter_id 
  AND b.doc_id = a.doc_id) AND moodle_id > 0  AND a.doc_id=" . $doc_id;

    $result = mysqli_query($dbc, $delete_archive) or die(mysqli_error($dbc));

}

function bInsert()
{
    global $dbc;
    global $doc_id;
    $select_query = "UPDATE  toc a SET binsert=1
WHERE moodle_id is null AND a.doc_id=" . $doc_id;
    $result = mysqli_query($dbc, $select_query) or die(mysqli_error($dbc));
    return $result;
}


function bChanged()
{


    global $doc_id;
    global $dbc;
    $toc_update = [];
    $archive_update = [];

    $query = "SELECT  chapter_id,chapter from toc  WHERE doc_id= " . $doc_id;

    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

    while ($row = mysqli_fetch_assoc($result)) {
        $chapter = $row["chapter"];

        $toc_update[$row["chapter_id"]] = $chapter;

    }

    if (count($toc_update) > 0) {

        $archiveQuery = "SELECT  chapter_id,chapter  from archived_toc  WHERE doc_id= " . $doc_id;

        $archiveResult = mysqli_query($dbc, $archiveQuery) or die(mysqli_error($dbc));

        while ($row = mysqli_fetch_assoc($archiveResult)) {

            $chapter = $row["chapter"];

            $archive_update[$row["chapter_id"]] = $chapter;

        }
    }


    $difference = array_diff($toc_update, $archive_update);
//
//echo "<pre>";
//print_r($difference);


    foreach ($difference as $key => $value) {

        $query = "UPDATE   toc a SET a.bChanged=1 WHERE chapter_id = '" . $key . "'";

        $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

        if (!$result) {
            echo "Something wrong  " . $result;
            exit;
        }
    }
    return $result;

}


//To archive table
function insertToArchive($docName, $dbc, $reimport, $doc_id, $content)
{
    global $url;
    global $server;
    global $details;
    global $user_id;

    mysqli_query($dbc, 'SET @@global.max_allowed_packet = ' . 5000 * 1024 * 1024) or die(mysqli_error($dbc));

    $docName = explode("(", $docName);
    $docName = $docName[0];

    if ($reimport == 1) {
        $query_update_document = 'UPDATE  document  SET doc_name= "' . $docName . '", content="' . mysqli_real_escape_string($dbc, $content) . '", document_url ="' . $url . '"
    WHERE id=' . $doc_id;

        $result = mysqli_query($dbc, $query_update_document);
        $documentId = mysqli_insert_id($dbc);

        if (!$result) {

            print_r("{state: false, name:'" . str_replace("'", "\\'", "Problem") . "', extra: {info: ' '}}");
            return;
        }

        $query_delete_prev = 'DELETE FROM archived_toc WHERE doc_id=' . $doc_id;

        $result = mysqli_query($dbc, $query_delete_prev) or die(mysqli_error($dbc));


        if ($result) {
            $export_query = 'INSERT INTO archived_toc
 (id,doc_id,sort_id,doc_name,date_time,chapter_id,chapter,parent_id,content,`type`,charVal,level_id,uppercss,lowercss,section_id,toUpdate,moodle_id,lesson_id,binsert,bUpdate,bDelete,bContent_update,bChanged)
SELECT id,doc_id,sort_id,doc_name,date_time,chapter_id,chapter,parent_id,content,`type`,charVal,level_id,uppercss,lowercss,section_id,toUpdate,moodle_id,lesson_id,binsert,bUpdate,bDelete,bContent_update,bChanged FROM toc
WHERE toc.doc_id= ' . $doc_id . ' ON DUPLICATE KEY UPDATE id=values(id),date_time=values(date_time),parent_id=values(parent_id),chapter_id=values(chapter_id),chapter=values(chapter)
,content=values(content),sort_id=values(sort_id),type =values(type),bUpdate =values(bUpdate),bChanged =values(bChanged),lesson_id =values(lesson_id),uppercss =values(uppercss),section_id =values(section_id),lowercss =values(lowercss),binsert =values(binsert),section_id =values(section_id),charVal =values(charVal),level_id =values(level_id),bDelete =values(bDelete),toUpdate = values(toUpdate)';


            $result = mysqli_query($dbc, $export_query) or die(mysqli_error($dbc));
        }

    } else {
        $dateTime = date("d.m.Y") . " " . date("h:i:sa");

        $query_insert_document = 'INSERT INTO document (doc_name, content,document_url,date_time,emp_id,details) VALUES ("' . $docName . '","' . mysqli_real_escape_string($dbc, $content) . '", "' . $url . '", "' . $dateTime . '", "' . $user_id . '", "' . $details . '")
    ON DUPLICATE KEY UPDATE content=values(content)';

        $result = mysqli_query($dbc, $query_insert_document) or die(mysqli_error($dbc));
        $documentId = mysqli_insert_id($dbc);

        if ($documentId) {

            $query = 'INSERT INTO course_server (document_id,server_id) VALUES (' . $documentId . ',' . $server . ')
            ON DUPLICATE KEY UPDATE document_id=values(document_id)';

            $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
            if (!$result) {
                echo "problem";
                exit();
            }

        }
    }
    return $documentId;
}

function getHeadingsWithContents($bodyContent, $content)
{

    try {
        global $insertRecords;
        global $docName;
        global $upperCss;
        global $lowerCss;
        global $qid1;
        //global $documentId;
        global $dbc;
        global $reimport;
        global $doc_id;
        global $contentPerChapter;
        $check = '';
        $size = count($bodyContent) - 1;
        $count = 0;
        $firstHeader = $bodyContent[0]->heading;
        $upperString = explode($firstHeader, $content);

        $upperString = $upperString[0];

        $documentId = insertToArchive($docName, $dbc, $reimport, $doc_id, $upperString);
        $prevContent = '';


        foreach ($bodyContent as $obj) {
            if (is_object($obj)) {
                if ($count < $size) {
                    $heading = strip_tags($obj->heading);
                    $heading = str_replace('&nbsp;', '', $heading);
                    $heading = trim(preg_replace('/\s+/', '', $heading));

                    $contentPerChapter = $obj->content;
                    list($chapter_id, $chapter_name) = getHeadlineInformations($heading);
                    $string_lenghth = $contentPerChapter;

                    $check = tableOfContents($obj->heading, $chapter_id, $chapter_name, $contentPerChapter, $string_lenghth, $upperCss, $lowerCss, $documentId);
                } else {
                    $last_obj = end($bodyContent);
                    $lastkey = $last_obj->heading;
                    $lastkey = strip_tags($lastkey);
                    $lastkey = str_replace('&nbsp;', '', $lastkey);
                    $lastkey = preg_replace('/\s+/', ' ', $lastkey);

                    $last_content = $last_obj->content;
                    $string_lenghth = $last_content;
                    list($last_chapter_id, $last_chapter_name) = getHeadlineInformations($lastkey);
                    $last_contentPerChapter = $last_content;
                    $check = tableOfContents($last_obj->heading, $last_chapter_id, $last_chapter_name, $last_contentPerChapter, $string_lenghth, $upperCss, $lowerCss, $documentId);


                }
                $count++;

            }
        }


    } catch (Exception $e) {

        echo "Problem!";
    }
    return $check;
}

function tableOfContents($key, $chapter_id, $chapter_name, $contentPerChapter, $string_lenghth, $upperCss, $lowerCss, $documentId)
{

    global $docName;
    global $sortId;
    global $parent_id;
    global $parent_id1;
    global $parent_id2;
    global $dbc;
    global $counter_l1;
    global $counter_l2;
    global $counter_l3;
    global $counter_l4;
    global $doc_id;
    global $reimport;
    global $qid;
    global $qid1;
    global $qsort;
    global $checkSections;
    $result = '';
    $string_lenghth = mysqli_real_escape_string($dbc, $string_lenghth);
    $docName = explode("(", $docName);
    $docName = $docName[0];
    $dateTime = date("d.m.Y") . " " . date("h:i:sa");
    $chapter1 = str_replace('nbsp;', '', $chapter_name);
    $chapter = str_replace('&', '', $chapter1);
    //$chapter = str_replace('?', '', $chapter);

    $chapter_num = str_replace('nbsp', '', $chapter_id);
    $chapter_nums = str_replace('&', '', $chapter_num);
    $id = '';
    $uStatus = '';
    if ($reimport == 1) {
        $uStatus = 1;
        $id = $doc_id;
    } else {
        $uStatus = 0;
        $id = $documentId;
    }

//    if (strpos($key, '</h5>') === false) {
//        if (strpos($key, '</h6>') === false) {
//
//            if (!trim($chapter_nums) && trim($chapter) && strpos($chapter, 'Table of content') === false) {
//                checkSection($id, $chapter);
//                $checkSections = 1;
//
//            }
//        }
//    }

    if (trim($chapter_nums)) {
        $section = explode(".", $chapter_nums);
        $section = $section[0];
        if ($section) {
            mysqli_query($dbc, 'SET @@global.max_allowed_packet = ' . 5000 * 1024 * 1024) or die(mysqli_error($dbc));
            if (strpos($key, '</h1>') !== false) {

                $parent_id = 0;
                $counter_l1++;
                $query_insert_toc = "INSERT INTO toc (doc_id,sort_id,doc_name, date_time, chapter_id, chapter, parent_id,content,type,charVal,level_id,uppercss,lowercss,section_id,toUpdate) 
                VALUES ('" . $id . "'," . ++$sortId . ",'" . $docName . "','" . $dateTime . "','" . $chapter_nums . "','" . trim($chapter) . "'," . $parent_id . ", '" . mysqli_real_escape_string($dbc, $contentPerChapter) . "','page','" . $string_lenghth . "','L1_" . $counter_l1 . "','" . mysqli_real_escape_string($dbc, $upperCss) . "','" . mysqli_real_escape_string($dbc, $lowerCss) . "','" . $section . "','" . $uStatus . "')
            ON DUPLICATE KEY UPDATE level_id=values(level_id),date_time=values(date_time),parent_id=values(parent_id),chapter=values(chapter),content=values(content),type =values(type),bUpdate =values(bUpdate),bChanged =values(bChanged),uppercss =values(uppercss),lowercss =values(lowercss),binsert =values(binsert),charVal =values(charVal),section_id =values(section_id),bDelete =values(bDelete),toUpdate =" . $uStatus;

                $result = mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));
                $parent_id = mysqli_insert_id($dbc);
                $counter_l2 = 0;
                $qid1 = $parent_id;

            } else if (strpos($key, '</h2>') !== false) {
                $counter_l2++;
                $query_insert_toc = "INSERT INTO toc (doc_id,sort_id,doc_name, date_time, chapter_id, chapter, parent_id,content,type,charVal,level_id,uppercss,lowercss,section_id,toUpdate)
             VALUES ('" . $id . "'," . ++$sortId . ",'" . $docName . "','" . $dateTime . "','" . $chapter_nums . "','" . trim($chapter) . "'," . $parent_id . ", '" . mysqli_real_escape_string($dbc, $contentPerChapter) . "','lesson','" . $string_lenghth . "','L2_" . $counter_l1 . "." . $counter_l2 . "','" . mysqli_real_escape_string($dbc, $upperCss) . "','" . mysqli_real_escape_string($dbc, $lowerCss) . "','" . $section . "','" . $uStatus . "')
             ON DUPLICATE KEY UPDATE level_id=values(level_id),date_time=values(date_time),parent_id=values(parent_id),chapter=values(chapter),content=values(content),type =values(type),bUpdate =values(bUpdate),bChanged =values(bChanged),uppercss =values(uppercss),lowercss =values(lowercss),binsert =values(binsert),charVal =values(charVal),section_id =values(section_id),bDelete =values(bDelete),toUpdate =" . $uStatus;
                $result = mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));
                $parent_id1 = mysqli_insert_id($dbc);
                $counter_l3 = 0;
                $qid1 = $parent_id1;

            } else if (strpos($key, '</h3>') !== false) {
                $counter_l3++;
                $query_insert_toc = "INSERT INTO toc (doc_id,sort_id,doc_name, date_time, chapter_id, chapter, parent_id,content,type,charVal,level_id,uppercss,lowercss,section_id,toUpdate) 
            VALUES ('" . $id . "'," . ++$sortId . ",'" . $docName . "','" . $dateTime . "','" . $chapter_nums . "','" . trim($chapter) . "'," . $parent_id1 . ", '" . mysqli_real_escape_string($dbc, $contentPerChapter) . "','lessonpage','" . $string_lenghth . "','L3_" . $counter_l1 . "." . $counter_l2 . "." . $counter_l3 . "','" . mysqli_real_escape_string($dbc, $upperCss) . "','" . mysqli_real_escape_string($dbc, $lowerCss) . "','" . $section . "','" . $uStatus . "')
            ON DUPLICATE KEY UPDATE level_id=values(level_id),date_time=values(date_time),parent_id=values(parent_id),chapter=values(chapter),content=values(content),type =values(type),bUpdate =values(bUpdate),bChanged =values(bChanged),uppercss =values(uppercss),lowercss =values(lowercss),binsert =values(binsert),charVal =values(charVal),section_id =values(section_id),bDelete =values(bDelete),toUpdate =" . $uStatus;
                $result = mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));
                $parent_id2 = mysqli_insert_id($dbc);
                $counter_l4 = 0;
                $qid1 = $parent_id2;


            } else {

                $counter_l4++;
                $query_insert_toc = "INSERT INTO toc (doc_id,sort_id,doc_name, date_time, chapter_id, chapter, parent_id,content,type,charVal,level_id,uppercss,lowercss,section_id,toUpdate) 
            VALUES ('" . $id . "'," . ++$sortId . ",'" . $docName . "','" . $dateTime . "','" . $chapter_nums . "','" . trim($chapter) . "'," . $parent_id2 . ", '" . mysqli_real_escape_string($dbc, $contentPerChapter) . "','lessonpage','" . $string_lenghth . "','L4_" . $counter_l1 . "." . $counter_l2 . "." . $counter_l3 . "." . $counter_l4 . "','" . mysqli_real_escape_string($dbc, $upperCss) . "','" . mysqli_real_escape_string($dbc, $lowerCss) . "','" . $section . "','" . $uStatus . "')
            ON DUPLICATE KEY UPDATE level_id=values(level_id),date_time=values(date_time),parent_id=values(parent_id),chapter=values(chapter),content=values(content),type =values(type),bUpdate =values(bUpdate),bChanged =values(bChanged),uppercss =values(uppercss),lowercss =values(lowercss),binsert =values(binsert),charVal =values(charVal),section_id =values(section_id),bDelete =values(bDelete),toUpdate =" . $uStatus;
                $result = mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));
                $qid1 = mysqli_insert_id($dbc);

            }

        }
    }
    if (strpos($key, '</h5>') !== false && $reimport == 0) {

        if ($parent_id2)
            $qid = checkQuestion($chapter, ++$qsort, $chapter_nums, $contentPerChapter, $qid1);

    } else if (strpos($key, '</h6>') !== false && $reimport == 0) {

        if ($qid)
            checkResponse($contentPerChapter, $qid, $qid1);

    }
    else if(!$chapter_num && strpos($chapter, 'Table of content') === false){
        $response = [
            'response' => false, 'text' => $chapter . " is missing chapter Id/Number kindly add chapter id/Number and try again!"
        ];
        $responses[] = $response;
        echo json_encode($responses);

        $obj = [
            'id' => $id,
            'doc_name' => $docName
        ];
        $curl = new curl;
        $serverurl = "http://".$_SERVER["HTTP_HOST"]. parse_url($_SERVER['HTTP_REFERER'],PHP_URL_PATH) ."controller/documents.php?action=5";
       $curl->get($serverurl, $obj);

exit;

    }

    return $result;

}

function checkSection($id, $chapter)
{
    global $reimport;

    if ($reimport) {

        $response = [
            'response' => false,
            'text' => trim($chapter) . ' :=> Does not have a section number to which it belongs, or the chapter id is not well written, kindly check it in your document and try again!',
        ];
        echo json_encode($response);
        exit();

    }
    $obj = ['id' => $id,];
    $curl = new curl;
    $serverurl = $_SERVER["DOCUMENT_ROOT"] . "/docs-extract/controller/documents.php?action=5";


    $resp = $curl->get($serverurl, $obj);
    $lessondata = json_decode($resp);

    if ($lessondata->response) {
        $response = [
            'response' => false,
            'text' => trim($chapter) . ' :=> Does not have a section number to which it belongs, or the chapter id is not well written, kindly check it in your document and try again!',
        ];
        echo json_encode($response);
        exit();
    }

}


function checkQuestion($chapter, $id, $chapter_nums, $contentPerChapter, $qid1)
{
    $ids = 0;
    $qtype = 0;
    if (strpos($chapter, 'multi') !== false) {

        $qtype = 3;
    }
    if (strpos($chapter, 'essay') !== false) {

        $qtype = 10;
    }
    if (strpos($chapter, 'matching') !== false) {

        $qtype = 5;
    }
    if (strpos($chapter, 'numerical') !== false) {

        $qtype = 8;
    }
    if (strpos($chapter, 'short') !== false) {

        $qtype = 1;
    }
    if (strpos($chapter, 'true/false') !== false) {

        $qtype = 2;
    }
    if ($qtype > 0) {

        $ids = addQuestions($id, $chapter_nums, $chapter, $contentPerChapter, $qtype, $qid1);
    }
    return $ids;
}


function checkResponse($contentPerChapter, $qid, $qid1)
{


    readHeadings($contentPerChapter, $qid, $qid1);


}

function readHeadings($contents, $qid, $qid1)
{
    global $dbc;
    if (!empty($contents)) {
        $document = new DOMDocument();

        $document->loadHTML($contents);

        $tags = array('p');
        $texts = array();

        foreach ($tags as $tag) {

            $elementList = $document->getElementsByTagName($tag);

            $sort = 0;
            foreach ($elementList as $element) {
                $score = 0;
                $text = explode("(", $element->textContent);

                if (!isset($text[1])) {
                    $text[1] = null;
                }
                $text = $text[1];
                $text = str_replace(")", "", $text);

                $score = $text != "" ? $text : $score;

                $response = $text != "" ? "Correct!" : "Wrong!";

                if ($element->textContent != '') {

                    $query_insert_toc = "INSERT INTO project_course_choices (question_id,text,score,response) 
               VALUES (" . $qid . ",'" . mysqli_real_escape_string($dbc, $element->textContent) . "'," . $score . ",'" . $response . "')
               ON DUPLICATE KEY UPDATE text=values(text)";

                    mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));
                }


            }
        }


    }
}

function addQuestions($sort_id, $chapter_nums, $chapter, $contentPerChapter, $qtype, $Page_id)
{
    global $dbc;

    $query_insert_toc = "INSERT INTO project_course_question (title,text,type)
VALUES ('" . $chapter_nums . $chapter . "','" . mysqli_real_escape_string($dbc, $contentPerChapter) . "'," . $qtype . ")
  ON DUPLICATE KEY UPDATE text=values(text)";

    mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));
    $qid = mysqli_insert_id($dbc);

    if ($qid) {
        $query_insert_toc = "INSERT INTO project_course_question_to_page (question_id,page_id,sort_id)
VALUES (" . $qid . "," . $Page_id . "," . $sort_id . ")";

        mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));

        $update_toc = "UPDATE toc SET hasQuestion = 1 where id=" . $Page_id;

        mysqli_query($dbc, $update_toc) or die(mysqli_error($dbc));
    }
    return $qid;
}

function deleteNonUpdate()
{
    global $doc_id;
    global $dbc;

    $query_delete = "DELETE FROM toc where doc_id= " . $doc_id . " AND toUpdate=0";
    $result = mysqli_query($dbc, $query_delete) or die(mysqli_error($dbc));

    if ($result) {

        $result = refreshUpdate();
    }

    return $result;
}

/**
 * @return bool|mysqli_result
 */
function bUpdate()
{
    global $doc_id;
    global $dbc;
    $toc_inserts = [];
    $archive_inserts = [];

    $query = " SELECT  chapter_id,charVal,content from toc  WHERE doc_id= " . $doc_id;
    $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

    while ($row = mysqli_fetch_assoc($result)) {
        $content = $row["charVal"];

        $content = strip_tags($content);
        $toc_inserts[$row["chapter_id"]] = $content;
    }

    if (count($toc_inserts) > 0) {

        $archiveQuery = "SELECT  chapter_id,charVal,content from archived_toc  WHERE doc_id= " . $doc_id;
        $archiveResult = mysqli_query($dbc, $archiveQuery) or die(mysqli_error($dbc));
        while ($row = mysqli_fetch_assoc($archiveResult)) {
            $content = $row["charVal"];
            $content = strip_tags($content);
            $archive_inserts[$row["chapter_id"]] = $content;

        }
    }

    $difference = array_diff($toc_inserts, $archive_inserts);

    foreach ($difference as $item => $val) {
        $query = "UPDATE   toc a SET a.bUpdate = 1 WHERE a.doc_id =" . $doc_id . "  AND a.chapter_id ='" . $item . "'";
        $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
        if (!$result) {
            echo "Something wrong  " . $result;
        }
    }


    $query_update = "UPDATE   archived_toc a SET a.bDelete=1
WHERE NOT  exists (select * from toc b WHERE  a.chapter_id=b.chapter_id)   AND moodle_id > 0  AND a.doc_id=" . $doc_id;

    $result = mysqli_query($dbc, $query_update) or die(mysqli_error($dbc));

    return $result;
}


function refreshUpdate()
{
    global $doc_id;
    global $dbc;
    $query_update = "UPDATE toc SET toUpdate=0  where doc_id= " . $doc_id;
    $result = mysqli_query($dbc, $query_update) or die(mysqli_error($dbc));

    return $result;
}

function getHeadlineInformations($string)
{
    $position = 0;
    $chapter_id = "";
    while (isValid_(substr($string, $position, 1))) {
        $chapter_id .= substr($string, $position++, 1);
    }

    return array($chapter_id, substr($string, $position));
}

//function to validate string
function isValid_($string)
{
    return is_numeric($string) || ctype_punct($string);
}

// Reading the headings of the file
function getContents($str, $startDelimiter, $endDelimiter)
{
    $contents = '';

    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;
    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
        $contentStart += $startDelimiterLength;
        $contentEnd = strpos($str, $endDelimiter, $contentStart);
        if (false === $contentEnd) {
            break;
        }
        $contents .= substr($str, $contentStart, $contentEnd - $contentStart);
        $startFrom = $contentEnd + $endDelimiterLength;
    }

    return $contents;
}

function getUrlHeadings($str, $delimiters)
{
    global $headings;

    $startEndDelimiters = explode(",", $delimiters);
    $startDelimiter = '<' . $startEndDelimiters[0];

    $endDelimiter = '<' . $startEndDelimiters[1] . '>';
    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;

    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {

        $contentStart += $startDelimiterLength;
        $contentEnd = strpos($str, $endDelimiter, $contentStart);
        if (false === $contentEnd) {
            break;
        }
        if ($startDelimiter == '<h1') {
            $headings[] = $contentStart . '<=><h1' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h1>';
        }

        if ($startDelimiter == '<h2') {
            $headings[] = $contentStart . '<=><h2' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h2>';
        }

        if ($startDelimiter == '<h3') {
            $headings[] = $contentStart . '<=><h3' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h3>';
        }

        if ($startDelimiter == '<h4') {
            $headings[] = $contentStart . '<=><h4' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h4>';
        }

        if ($startDelimiter == '<h5') {
            $headings[] = $contentStart . '<=><h5' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h5>';
        }

        if ($startDelimiter == '<h6') {
            $headings[] = $contentStart . '<=><h6' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h6>';
        }

        $startFrom = $contentEnd + $endDelimiterLength;
    }

    // return $contents;
}

//read Heading with css
function getHeadings($str, $delimiters, $startclose, $endclose)
{

    global $headings;

    $startEndDelimiters = explode(",", $delimiters);
    $startDelimiter = $startclose . $startEndDelimiters[0];

    $endDelimiter = $startclose . $startEndDelimiters[1] . $endclose;
    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;

    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {

        $contentStart += $startDelimiterLength;
        $contentEnd = strpos($str, $endDelimiter, $contentStart);
        if (false === $contentEnd) {
            break;
        }
        if ($startDelimiter == '<h1') {

            $head = '<h1' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h1>';
            $head = strip_tags($head);
            $head = trim($head, "\xC2\xA0");
            $head = str_replace('&nbsp;', '', $head);
            $head = str_replace(preg_match('/\s/', $head), '', $head);
            if ($head != '' || strpos($head, '&nbsp;') === false) {
                $headings[] = $contentStart . '<=><h1' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h1>';

            }

        }

        if ($startDelimiter == '<h2') {
            $head = '<h2' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h2>';
            $head = strip_tags($head);
            $head = trim($head, "\xC2\xA0");
            $head = str_replace('&nbsp;', '', $head);
            $head = str_replace(preg_match('/\s/', $head), '', $head);
            if ($head != '' || strpos($head, '&nbsp;') === false) {
                $headings[] = $contentStart . '<=><h2' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h2>';

            }
        }

        if ($startDelimiter == '<h3') {
            $head = '<h3' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h3>';
            $head = strip_tags($head);
            $head = trim($head, "\xC2\xA0");
            $head = str_replace('&nbsp;', '', $head);
            $head = str_replace(preg_match('/\s/', $head), '', $head);
            if ($head != '' || strpos($head, '&nbsp;') === false) {
                $headings[] = $contentStart . '<=><h3' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h3>';;

            }
        }

        if ($startDelimiter == '<h4') {
            $head = '<h4' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h4>';
            $head = strip_tags($head);
            $head = trim($head, "\xC2\xA0");
            $head = str_replace('&nbsp;', '', $head);
            $head = str_replace(preg_match('/\s/', $head), '', $head);
            if ($head != '' || strpos($head, '&nbsp;') === false) {
                $headings[] = $contentStart . '<=><h4' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h4>';

            }
        }

        if ($startDelimiter == '<h5') {
            $head = '<h5' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h5>';
            $head = strip_tags($head);
            $head = trim($head, "\xC2\xA0");
            $head = str_replace('&nbsp;', '', $head);
            $head = str_replace(preg_match('/\s/', $head), '', $head);
            if ($head != '' || strpos($head, '&nbsp;') === false) {
                $headings[] = $contentStart . '<=><h5' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h5>';

            }
        }

        if ($startDelimiter == '<h6') {
            $head = '<h6' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h6>';
            $head = strip_tags($head);
            $head = trim($head, "\xC2\xA0");
            $head = str_replace('&nbsp;', '', $head);
            $head = str_replace(preg_match('/\s/', $head), '', $head);
            if ($head != '' || strpos($head, '&nbsp;') === false) {
                $headings[] = $contentStart . '<=><h6' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h6>';

            }
        }

        $startFrom = $contentEnd + $endDelimiterLength;
    }

}
