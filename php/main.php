<?php

ini_set('display_errors', '1');


require_once $_SERVER["DOCUMENT_ROOT"] . '/GoogleDocsAPI/vendor/autoload.php';
include 'functions.php';

session_start();
$accesstoken = $_SESSION['access_token'];





function getBody($html){

  $client = new Google_Client();
  $client->setAuthConfig($_SERVER["DOCUMENT_ROOT"] . '/GoogleDocsAPI/client_secrets.json');
  $client->setScopes(Google_Service_Docs::DOCUMENTS);
  $client->addScope(Google_Service_Drive::DRIVE);
  $client->setAccessType('offline');



  $levels=0;
  $parent_id=0;
  $sort_id=0;
  $insertRecords = [];
  $toc_raw = [];
  $content_raw = [];
  $content_image = [];
  $content_chunk = array();
  $service="";
  $documentId="";
  $doc="";
  $inlineObjects="";
  $subArray="";

  $topics=[];   
  
  

  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
      $service = new Google_Service_Docs($client);
      $documentId = '1loR2S3tnpFndy2QVVRTI-_6u-k_f5kNb-PlL4c7U1LY';
      $doc = $service->documents->get($documentId);
      $inlineObjects = $doc->getInlineObjects();
      $docName = $doc->getTitle();
      $doccode = explode(" ",$docName);
      $doc_code = $doccode[0];
      $connect_to_db = $dbc;

      $document_Cod = "gap";
      $doc_id_content = "doc";
      $toc_id_content = "toc";
      $content_name="";
      $tableContents="";
    

    
      
      //Loop through the document getting its contents
      foreach ($doc['body']['content'] as $content) {

        $html .= getTable($content);


            

      }


  }  else {
      $redirect_uri = 'https://bo.nts.nl/GoogleDocsAPI/oauth2callback.php';
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }

  return $html;
}


  
      
        //check if token is valid

    