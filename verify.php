<?php
$access_token = '+iEjRFtp16exBGaNleTlwMtIRqyQvzy4KyNrSOQMlsUERuEbj6W6RruPm7RShfVS9ABUcXWK8xj4fRTm0xKnX66A0MnErwGx+AhlRjlULfn5rhH27tRw/9Dg8hKID5u41WKN0ykvNOLH2BxeRsohfQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
