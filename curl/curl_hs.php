<?php
function curlProc($url, $method, $request, $header, $timeOut) {
    $ch = curlV2($url, $method, $request, $header, $timeOut);
    $content = curl_exec($ch);
    return getResult($ch, $content);
}

function curlV2($url, $method, $request, $header, $timeOut) {
    $ch = init($url, $timeOut);
    return  methodFactory($method, $ch, $request, $header);
}

function methodFactory($method, $ch, $request, $header) {
    $result = null;

    if ($method === 'GET' || $method === 'JSON') $result = doGet($ch);
    elseif ($method === 'POST') {
        $result = doPost($ch, $request, $header);
    }
    elseif ($method === 'PATCH') $result = doPatch($ch);
    elseif ($method === 'PUT') $result = doPut($ch);
    elseif ($method === 'DELETE') $result = doDelete($ch);

    return $result;
}

function doGet($ch) {
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    return $ch;
}

function doPost($ch, $request, $header) {
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

    if(!empty($header)) {
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    return $ch;
}

function getResult($ch, $content) {
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return ['content'=>$content,'status'=>$status];
}

function doPatch($ch) {

}

function doPut($ch) {

}

function doDelete($ch) {

}

function init($url, $timeOut) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);

    return $ch;
}

function is_number($num) {
    return !is_integer($num);
}