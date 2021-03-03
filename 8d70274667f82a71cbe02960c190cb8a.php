<?php 
     define('_SAPE_USER', '8d70274667f82a71cbe02960c190cb8a');
     require_once($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php'); 
     $sape_articles = new SAPE_articles();
     echo $sape_articles->process_request();
?>
