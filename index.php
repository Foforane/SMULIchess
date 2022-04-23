<?php

$api_url = "https://lichess.org/api/user/CyberT";

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL,$api_url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

$res = curl_exec($ch);
curl_close($ch);
$res = json_decode($res);
$Blitz = $res->perfs->blitz->rating;

echo $Blitz;
?>