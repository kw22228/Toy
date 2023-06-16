<?php
const GET_METHOD = 'GET';
const POST_METHOD = 'POST';
const DELETE_METHOD = 'DELETE';
const PUT_METHOD = 'PUT';

function useCurl($url, $method, $request, $header, $timeOut, $is_result = false)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if ($method === POST_METHOD) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    }
    if ($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    if (is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);

    $content = curl_exec($ch);
    return !$is_result ? $content : [
        'content' => $content,
        'status' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
    ];
}

function curlPost($url, $request, $timeOut)
{
    return useCurl($url, POST_METHOD, $request, null, $timeOut);
}

function curlPostResult($url, $request, $timeOut)
{
    return useCurl($url, POST_METHOD, $request, null, $timeOut, true);
}

function curlGet($url, $timeOut)
{
    return useCurl($url, GET_METHOD, null, null, $timeOut);
}
