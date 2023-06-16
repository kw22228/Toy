<?php
function curlPost($url,$request, $timeOut){
    $request = (is_array($request)? http_build_query($request):$request);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
    $content = curl_exec($ch);
    return $content;
}

function curlGet($url, $timeOut){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
    $content = curl_exec($ch);
    return $content;
}

function curlPostResult($url,$request, $timeOut){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_POST,1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
  $content = curl_exec($ch);
  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  return ['content'=>$content,'status'=>$status];
}

function curlPostHeader($url,$request,$header, $timeOut){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_POST,1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_HEADER, 0); 
  if($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
  $content = curl_exec($ch);
  return $content;
}

function curl($url, $method, $request, $header, $timeOut){
    $ch = curl_init();

    if($method !== 'GET') curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);

    $content = curl_exec($ch);
    return $content;
}


function curlJson($url, $method, $request, $header, $timeOut){
    $ch = curl_init();

    if($method !== 'GET') curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    if(is_number($timeOut) && $timeOut > 0) curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);

    $content = curl_exec($ch);
      $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      return ['content'=>$content,'status'=>$status];
}

