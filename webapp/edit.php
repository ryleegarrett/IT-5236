<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $listID = $_POST['listID'];
    
    if (array_key_exists('fin', $_POST)) {
        $complete = 1;
    } else {
        $complete = 0;
    }
    if (empty($_POST['finBy'])) {
        $finBy = null;
    } else {
        $finBy = $_POST['finBy'];
    }
    $listItem = $_POST['listItem'];
    
    
    $url = "http://35.173.247.206/api/task.php?listID=$listID";
    
    //create json string
    $data = json_encode([
        'taskName' => $listItem,
        'taskDate' => $finBy,
        'completed' => $complete
    ]);

    //Define Curl request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpcode == 204) { //Status code 204
        header("Location: index.php");
    } else { //Status code not 204
        header("Location: index.php?error=edit");
        }
    }
?>
