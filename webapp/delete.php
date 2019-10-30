<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$url = "http://35.173.247.206/api/task.php?listID={$_POST['listID'])";

	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 204) {
    	header("Location: index.php");
    }	else {
		header("Location: index.php?error=delete");
	}
}


?>
