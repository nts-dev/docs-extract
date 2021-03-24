<?php
//	include("docx_metadata.php");
//	$docxmeta = new docxmetadata();
//
//	$docxfile = "Moodle tutorial.doc";
//	$docxmeta->setDocument($docxfile);
//
//	echo "<strong>File : ".$docxfile . "</strong><br>";
//	echo "Title : " . $docxmeta->getTitle() . "<br>";
//	echo "Subject : " . $docxmeta->getSubject() . "<br>";
//	echo "Creator : " . $docxmeta->getCreator() . "<br>";
//	echo "Keywords : " . $docxmeta->getKeywords() . "<br>";
//	echo "Description : " . $docxmeta->getDescription() . "<br>";
//	echo "Last Modified By : " . $docxmeta->getLastModifiedBy() . "<br>";
//	echo "Revision : " . $docxmeta->getRevision() . "<br>";
//	echo "Date Created : " . $docxmeta->getDateCreated() . "<br>";
//	echo "Date Modified : " . $docxmeta->getDateModified() . "<br>";
//?>

<?php

// htmlviewer.php
// convert a Word doc to an HTML file

//$DocumentPath = str_replace("\\", "\", $DocumentPath);
$DocumentPath="Moodle tutorial.doc";

// create an instance of the Word application
$word = new COM("word.application") or die("Unable to instantiate application object");

// creating an instance of the Word Document object
$wordDocument = new COM("word.document") or die("Unable to instantiate document object");
$word->Visible = 0;
// open up an empty document
$wordDocument = $word->Documents->Open($DocumentPath);

// create the filename for the HTML version
$HTMLPath = substr_replace($DocumentPath, 'txt', -3, 3);

// save the document as HTML
$wordDocument->SaveAs($HTMLPath, 3);

// clean up
$wordDocument = null;
$word->Quit();
$word = null;

// redirect the browser to the newly-created document header("Location:". $HTMLPath);

header("Location:". $HTMLPath);
?>
