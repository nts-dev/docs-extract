

<?php
include 'config.php';
$headings = array();
$upperCss = "";
$lowerCss = "";
$docName = "";
$sortId = 0;

$insertRecords = [];
$filename = "";

//echo $filename;
if ($_FILES["file"]["name"]) {
    $filename = $_FILES["file"]["name"];
    $source = $_FILES["file"]["tmp_name"];
    $type = $_FILES["file"]["type"];

    $name = explode(".", $filename);
    $docName = $name[0];

    $accepted_types = array('application/zip', 'application/x-zip-compressed',
        'multipart/x-zip', 'application/x-compressed');
    foreach ($accepted_types as $mime_type) {
        if ($mime_type == $type) {
            $okay = true;
            break;
        }
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if (!$continue) {
        $myMsg = "Please upload a valid .zip file.";
    }

    /* PHP current path */
    $path = dirname(__FILE__) . '/';
    $filenoext = basename($filename, '.zip');
    $filenoext = basename($filenoext, '.ZIP');
    //$path_html=;
    $myDir = $path . $filenoext; // target directory
    $myFile = $path . $filename; // target zip file

    if (move_uploaded_file($source, $myFile)) {
        $zip = new ZipArchive();

        // echo $filenoext;

        $x = $zip->open($myFile); // open the zip file to extract
        if ($x === true) {
            $zip->extractTo($myDir); // place in the directory with same name

            readGoogleDocHtml($myDir, $filename);

            $zip->close();
            // unlink($myFile);
        }
        $myMsg = "Your .zip file uploaded and unziped.";

        print_r("{state: true, name:'" . str_replace("'", "\\'", $filename) . "',  extra: {info: $myMsg }}");
    } else {
        $myMsg = "There was a problem with the upload.";
        print_r("{state: false, name:'" . str_replace("'", "\\'", $filename) . "',  extra: {info: $myMsg }}");
    }
}

function readGoogleDocHtml($path, $fileName)
{

    // $heading = [];
    $zip = zip_open($fileName);

    if ($zip) {
        if ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry)) {

                $contents = file_get_contents($path . "/" . zip_entry_name($zip_entry), 1);
                echo $path;

                $content = str_replace("images/image", "https://bo.nts.nl/GoogleDocsAPI/images/image", $contents);

                readHeaders($content);

                zip_entry_close($zip_entry);
            }

        }
        zip_close($zip);
    }

}

function readHeaders($contents)
{
    $heading_arrays = array('<h1,</h1>', '<h2,</h2>', '<h3,</h3>', '<h4,</h4>', '<h5,</h5>', '<h6,</h6>');
    global $headings;

    foreach ($heading_arrays as $heading_array) {

        $heading = getHeadings($contents, $heading_array);
        //$headings[] = $heading;

    }
    sort($headings, SORT_NATURAL | SORT_FLAG_CASE);

    readContents($headings, $contents);

}

function readContents($headings, $content)
{
    global $upperCss;
    global $lowerCss;

    $Delimiter1s = $headings[0];
    $startDelimiters1s = explode(",", $Delimiter1s);
    $firstDelimiters = $startDelimiters1s[1];

    $styling = explode($firstDelimiters, $content);

    $upperCss = $styling[0];

    $bodyContent = array();

    $arraySize = count($headings);
    $count = 0;
    while ($count < $arraySize - 1) {

        $Delimiter1 = $headings[$count];
        $startDelimiters1 = explode(",", $Delimiter1);
        $firstDelimiter = $startDelimiters1[1];

        $Delimiter2 = $headings[$count + 1];
        $startDelimiters2 = explode(",", $Delimiter2);
        $secondDelimiter = $startDelimiters2[1];

        $Delimiter = $firstDelimiter . "," . $secondDelimiter;

        $bodyContent[$firstDelimiter] = getContents($content, $Delimiter);
        $count++;

    }

    $firstDelimiter = $headings[$arraySize - 1];

    $lastString = explode($firstDelimiter, $content);

    $bodyContent[$firstDelimiter] = $lastString[1];

    //$bstyle = explode($lastString[1], $content);

    $lowerCss = '<div>
    <p class="c20 c16 c35"><span class="c1"></span></p>
</div>
</body>

</html>';

    getHeadingsWithContents($bodyContent, $content);
}

function getHeadingsWithContents($bodyContent, $content)
{
    global $insertRecords;
    global $docName;
    global $upperCss;
    global $lowerCss;

    //echo $docName;

    foreach ($bodyContent as $key => $contents) {

        list($chapter_id, $chapter_name) = getHeadlineInformations(strip_tags($key));
        // echo $chapter_id;

        $contentPerChapter = $upperCss . $key . $contents[0] . $lowerCss;
        tableOfContents($chapter_id, $chapter_name, $contentPerChapter, $content);
    }
    //echo "<pre>";
    // print_r($insertRecords);
    insertToDB($docName, $content, $insertRecords);
}
function tableOfContents($chapter_id, $chapter_name, $contentPerChapter)
{
    global $insertRecords;
    global $documentId;
    global $docName;
    global $sortId;
    $parent_id = 0;

    $level = 0;

    //$doc_name = str_replace($doc_code,"" ,$docName);

    $dateTime = date("d.m.Y") . " " . date("h:i:sa");
    $chapter = str_replace("nbsp;", '', $chapter_name);
    $chapters = str_replace("&", '', $chapter);

    $chapter_num = str_replace("nbsp", '', $chapter_id);
    $chapter_nums = str_replace("&", '', $chapter_num);

    if ($chapters != "" || trim($chapter_nums != "")) {

        $insertRecords[] = "( doc_id,'" . $docName . "'," . ++$sortId . ",'" . $dateTime . "', " . $parent_id . ", " . $level . ", '" . $chapter_nums . "', '" . trim($chapters) . "', '" . $contentPerChapter . "')";

    }

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
function getContents($str, $delimiters)
{
    $contents = array();
    $startEndDelimiters = explode(",", $delimiters);
    $startDelimiter = $startEndDelimiters[0];
    $endDelimiter = $startEndDelimiters[1];
    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;
    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
        $contentStart += $startDelimiterLength;
        $contentEnd = strpos($str, $endDelimiter, $contentStart);
        if (false === $contentEnd) {
            break;
        }
        $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
        $startFrom = $contentEnd + $endDelimiterLength;
    }

    return $contents;
}

//read Heading with css
function getHeadings($str, $delimiters)
{

    global $headings;

    $startEndDelimiters = explode(",", $delimiters);
    $startDelimiter = $startEndDelimiters[0];

    $endDelimiter = $startEndDelimiters[1];
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
            $headings[] = $contentStart . ',<h1' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h1>';
        }

        if ($startDelimiter == '<h2') {
            $headings[] = $contentStart . ',<h2' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h2>';
        }

        if ($startDelimiter == '<h3') {
            $headings[] = $contentStart . ',<h3' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h3>';
        }

        if ($startDelimiter == '<h4') {
            $headings[] = $contentStart . ',<h4' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h4>';
        }

        if ($startDelimiter == '<h5') {
            $headings[] = $contentStart . ',<h5' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h5>';
        }

        if ($startDelimiter == '<h6') {
            $headings[] = $contentStart . ',<h6' . substr($str, $contentStart, $contentEnd - $contentStart) . '</h6>';
        }

        $startFrom = $contentEnd + $endDelimiterLength;
    }

    // return $contents;
}

function insertToDB($docName, $html, $insertRecords)
{

    if ($docName != "" && $html != "") {

        global $dbc;
        $query_insert_document = 'INSERT INTO moodle_doc_db.documents (doc_name, content) VALUES ("' . $docName . '","' . mysqli_real_escape_string($dbc, $html) . '")
ON DUPLICATE KEY UPDATE content=values(content)';

        $result = mysqli_query($dbc, $query_insert_document) or die(mysqli_error($dbc));
        $documentId = mysqli_insert_id($dbc);
        if ($result) {

            $insertString = implode(',', $insertRecords);

            if (count($insertRecords) > 0) {
                $query_insert_toc = "INSERT INTO moodle_doc_db.google_docs (doc_id, doc_name,sort_id,last_revised, parent_id, level, toc_chapter, toc_name,content_html) VALUES " . str_replace("doc_id", $documentId, $insertString)
                    . "ON DUPLICATE KEY UPDATE last_revised=values(last_revised),parent_id=values(parent_id),level=values(level),toc_chapter=values(toc_chapter),toc_name=values(toc_name),content_html=values(content_html)";

                $result = mysqli_query($dbc, $query_insert_toc) or die(mysqli_error($dbc));

                if ($result) {
                    $data['data'] = array('response' => true, 'text' => 'Successfully Added');

                    echo "Done";
                } else {

                    $data['data'] = array('response' => false, 'text' => 'An Error Occured While Saving');
                }
            }
        }
    } else {
        // echo "ddd";
        //$data['data'] = array('response' => false, 'text' => 'An Error Occured While Saving');
    }

//echo json_encode($data);
}