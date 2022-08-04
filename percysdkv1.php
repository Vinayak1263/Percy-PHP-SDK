<?php

function is_percy_enabled() {
$url = 'http://localhost:5338/percy/healthcheck'; 

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);

    $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    curl_close($ch);

    if($status == 200)
        return true;

    return false;
 
}


function fetch_percy_dom() {

    $url = 'http://localhost:5338/percy/dom.js';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    return $response;

}





function percy_snapshot($web_driver, $name) {

    echo $name;
    if(! is_percy_enabled())
        return;
        


    $web_driver->executeScript(fetch_percy_dom());
    $dom_snapshot = $web_driver->executeScript('return PercyDOM.serialize()');

    echo $dom_snapshot;

    $ch = curl_init('http://localhost:5338/percy/snapshot');
    
    $fields = ['domSnapshot' => $dom_snapshot, 'url' => $web_driver->getCurrentURL(),'name' => $name];

    $fields_json = json_encode($fields);
    $options = [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $fields_json, 
        CURLOPT_RETURNTRANSFER => true];

    curl_setopt_array($ch, $options);

    $data = curl_exec($ch);
    
    curl_close($ch);
    
    echo $data;

}


?>