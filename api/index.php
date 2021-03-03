<?php
header('Content-type: text/html; charset=UTF-8');
//error_log('index');
if (count($_POST)>0){
    require_once 'apiEngine.php';
    foreach ($_POST as $apiFunctionName => $apiFunctionParams) {
		//error_log($apiFunctionName);
		//error_log(json_encode($apiFunctionParams));
        $APIEngine=new APIEngine($apiFunctionName,$apiFunctionParams);
		//$APIEngine=new APIEngine($apiFunctionName,json_encode($apiFunctionParams));
        echo $APIEngine->callApiFunction(); 
        break;
    }
}else{
    @$jsonError->error='No function called';
    echo json_encode($jsonError);
}
?>