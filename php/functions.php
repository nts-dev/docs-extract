<?php

//function loop headings
header("Access-Control-Allow-Origin: *");
function getBody($doc_url)
{

    try {
        global $doc_code;
        global $dbc;
        global $html;
        global $tables;
        global $docName;
        global $doc_url;

        global $content;
        $client = new Google_Client();
        $client->setAuthConfig($_SERVER["DOCUMENT_ROOT"] . '/GoogleDocsAPI/client_secrets.json');
        $client->setScopes(Google_Service_Docs::DOCUMENTS);
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Docs($client);
            $doc_id_left = explode('/d/', $doc_url);

            $doc_id_right = explode("/", $doc_id_left[1]);
            $documentId = $doc_id_right[0];
            $doc = $service->documents->get($documentId);
            $inlineObjects = $doc->getInlineObjects();
            $docName = $doc->getTitle();

            $doccode = explode(" ", $docName);
            $doc_code = $doccode[0];
            $connect_to_db = $dbc;
            $inserts = [];
            $document_Cod = "gap";
            $doc_id_content = "doc";
            $toc_id_content = "toc";
            $content_name = "";
            $tableContents = "";
       
            foreach ($doc['body']['content'] as $bodyContent) {
                $simpleElement = $bodyContent->toSimpleObject();

                $contents = $bodyContent["paragraph"];

                if (isset($contents)) {
                    $html .= getContent($contents);
                }
                if (isset($bodyContent->table)) {
                    $table = buildTable($bodyContent);
                    $html .= $table;

                    $content .= $table;
                }

                if (isset($inlineObjects) && isset($simpleElement->paragraph)) {
                    $image = buildImageUrl($simpleElement, $inlineObjects, "");
                    $html .= $image;

                    $content .= $image;
                }
            }
        } else {
            $redirect_uri = 'https://bo.nts.nl/GoogleDocsAPI/oauth2callback.php';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
        // return $html;
    } catch(Exception $e){
        print "An error occurred: " . $e->getMessage();
    }
}

function getContent($contentArray)
{
    global $html;
    global $content;
    global $dbc;

    $headings = $contentArray["paragraphStyle"]["namedStyleType"];
  
    foreach ($contentArray['elements'] as $subcontents) {

        $paragraph = $subcontents["textRun"]["content"];

        if (isTypeHead($headings)) {


            tableOfContents(mysqli_real_escape_string($dbc, $content));

        if ($paragraph!="") {
            $content="";
        }

            $html .= buildHeadline($headings, $paragraph);
        } else {

            list($start, $end) = paragraphstyleBold($subcontents);

            $html .= $start . buildParagraph($paragraph, "") . $end;

            $content .= $start . buildParagraph($paragraph, "") . $end;
        }

    }

}

function isTypeHead($headings)
{

    return false !== strpos($headings, "HEADING");

}


function buildHeadline($headings, $subs)
{
    $headline="";
    global $chapter_id;
    global $chapter_name;
    global $level;

    if ($headings == "HEADING_1") {
        $level = 1;
        $headline .= '<h1 class="c28 c20" id="h.1rn73xw9uwtq"><span class="c33">';
        $headline .= $subs . "<br>";
        $headline .= '</span></h1>';

        list($chapter_id, $chapter_name) = getHeadlineInformation($subs);


    } else if ($headings == "HEADING_2") {
        $level = 2;
        $headline .= '<h2 class="c9" id="h.gkn4eo9tlpo5"><span class="c11">';
        $headline .= $subs . "<br>";
        $headline .= '</span></h2>';

        list($chapter_id, $chapter_name) = getHeadlineInformation($subs);



    } else {
        $level = 3;
        $headline .= '<h3 class="c7" id="h.4uf33vf8hk2m"><span class="c3">';
        $headline .= $subs . "<br>";
        $headline .= '<br></span></h3>';

        list($chapter_id, $chapter_name) = getHeadlineInformation($subs);

    }

    // return $headline;
    return $headline;
}

//function to Get title information
function getHeadlineInformation($string)
{

    $position = 0;
    $chapter_id = "";
    while (isValid(substr($string, $position, 1))) {
        $chapter_id .= substr($string, $position++, 1);
    }

    $chapter_name = substr($string, $position);

    return array($chapter_id, substr($string, $position));
}

//function create table of contents

function tableOfContents($content)
{
    global $insertRecords;
    global $documentId;
    global $docName;
    global $sortId ;
    global $parent_id;
    global $chapter_id;
    global $chapter_name;
    global $level;

    //$doc_name = str_replace($doc_code,"" ,$docName);

    $dateTime = date("d.m.Y")." ".date("h:i:sa") ;

    if ($chapter_id != ""||trim($chapter_name) != ""){


        $insertRecords[] = "( doc_id,'". $docName . "',". ++$sortId . ",'".$dateTime . "', " . $parent_id . ", " . $level . ", '" . $chapter_id . "', '" . trim($chapter_name) . "', '".$content."')";

    }

}

//function to validate string
function isValid($string)
{
    return is_numeric($string) || ctype_punct($string);
}
//function to create image links
function buildImageUrl($simpleElement, $inlineObject, $imageUrl)
{
    
    $imageId = $simpleElement->paragraph->elements[0]->inlineObjectElement->inlineObjectId;

    $image = $inlineObject[$imageId]["inlineObjectProperties"]["embeddedObject"]["imageProperties"]["contentUri"];
    if ($image) {
        $imageUrl .= '<p><span
    style="overflow: hidden; display: inline-block; margin: 0.00px 0.00px; border: 0.00px solid #000000; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px); width: 602.00px; height: 310.67px;"><img
        alt="" src="' . $image . '" style=" width: 100%; height: 100%; margin-left: 0.00px; margin-top: 0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);"
        title=""></span></p></br></br>';
    }
  
    return $imageUrl;

}

//function get contents per heading

function buildParagraph($paragraph, $paragraphContent)
{
    global $content_raw;

    return $paragraphContent . '<p class="c5"> ' . $paragraph . '</p>';

}

//Function to get tables
function buildTable($content)
{
    
    $table = '<table class="c45"';
    $table .= '<tbody>';
    $count = 0;

    foreach ($content->table->tableRows as $row) {

        if ($count == 0) {
            $table .= '<tr >';

        } else {
            $table .= '<tr >';

        }

        foreach ($row->tableCells as $cells) {

            $styling = tableCellStyle($cells, $table);

            $cellStyle = "";

            foreach ($cells->content as $content) {
                foreach ($content->paragraph->elements as $element) {

                    $cellStyle = rowStyle($element);

                }
            }

            if ($count == 0) {
                $table .= '<td class="c18 " ' . $cellStyle . $styling . '>';

            } else {
                $table .= '<td class="c18" ' . $styling . '>';

            }
            foreach ($cells->content as $content) {
                foreach ($content->paragraph->elements as $element) {

                    $style = textStyle($element);

                    $table .= $style . '>' . $element->textRun->content . '</p>';
                }
            }

            $table .= '</td>';

        }

        $table .= '</tr>';

        $count++;
    }

    $table .= '</tbody> ';
    $table .= '</table> ';

    
    return $table;

}

function tableCellStyle($cells, $table)
{

    $style = "";

    foreach ($cells->content as $content) {
        foreach ($content->paragraph->elements as $element) {

            $style = textStyle($element);

            $table .= $style . '>' . $element->textRun->content . '</p>';
        }
    }

    $style .= "columnSpan =  '" . $cells->tableCellStyle->columnSpan . "'";

    $style .= "rowSpan =  '" . $cells->tableCellStyle->rowSpan . "'";

    $style .= "paddingLeft =  '" . $cells->tableCellStyle->paddingLeft->magnitude . "'";

    $style .= "paddingRight =  '" . $cells->tableCellStyle->paddingRight->magnitude . "'";

    $style .= "paddingTop =  '" . $cells->tableCellStyle->paddingTop->magnitude . "'";

    $style .= "paddingBottom =  '" . $cells->tableCellStyle->paddingBottom->magnitude . "'";

    return $style;
}

function tableRowStyle($row)
{

}

function textStyle($element)
{

    $style = "";


    $fontweight = $element->textRun->textStyle->weightedFontFamily->weight;
    $fontFamily = $element->textRun->textStyle->weightedFontFamily->fontFamily;
    $fontSize = $element->textRun->textStyle->fontSize->magnitude;

    $rgbColor = $element->textRun->textStyle->backgroundColor->color->rgbColor;

    $blue = $rgbColor->blue * 255;
    $green = $rgbColor->green * 255;
    $red = $rgbColor->red * 255;

    if ($blue == 0 && $green == 0 && $red == 0) {
        $blue = 255;
        $green = 255;
        $red = 255;

    }

    list($start, $end) = textstyleBold($element);

    $style .= $start . '<p style ="font-size:' . $fontSize . 'pt; font-family:' . $fontFamily . '; font-weight:' . $fontweight . '; background-color:rgb(' . $red . ', ' . $green . ', ' . $blue . ');"';

    return $style;

}

function textstyleBold($element)
{

    $styleOpen = "";
    $styleclose = "";

    $bold = $element->textRun->textStyle->bold;

    if ($bold == "1") {

        $styleOpen .= '<b>';

        $styleclose .= '</b>';
    }

    return array($styleOpen, $styleclose);

}

function paragraphstyleBold($subcontents)
{

    $styleOpen = "";
    $styleclose = "";

    $style = textStyle($subcontents);

    $bold = $subcontents->textRun->textStyle->bold;

    if ($bold == "1") {

        $styleOpen .= $style . '<b>';

        $styleclose .= '</b> </p>';
    } else {
        $styleOpen = "";
        $styleclose = "";

        $styleOpen .= $style . '';

        $styleclose .= ' </p>';
    }

    return array($styleOpen, $styleclose);

}

function rowStyle($element)
{

    $style = "";
    //$style .=$type .$element->textRun->textStyle->bold;

    $fontweight = $element->textRun->textStyle->weightedFontFamily->weight;
    $fontFamily = $element->textRun->textStyle->weightedFontFamily->fontFamily;
    $fontSize = $element->textRun->textStyle->fontSize->magnitude;

    $rgbColor = $element->textRun->textStyle->backgroundColor->color->rgbColor;

    $blue = $rgbColor->blue * 255;
    $green = $rgbColor->green * 255;
    $red = $rgbColor->red * 255;

    if ($blue == 0 && $green == 0 && $red == 0) {
        $blue = 255;
        $green = 255;
        $red = 255;

    }

    $style .= 'style ="background-color:rgb(' . $red . ', ' . $green . ', ' . $blue . ');"';

    return $style;

}
