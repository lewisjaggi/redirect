<?php
include_once('data.php');
$url = "http://ip-api.com/json/";

$ip = getRealIpAddr();

//The URL that we want to GET.
$urlIp = "$url$ip";

//Use file_get_contents to GET the URL in question.
$contents = file_get_contents($urlIp);

//If $contents is not a boolean FALSE value.
if ($contents !== false) {
    $json = json_decode($contents);

    if (isset($json->countryCode)) {
        goToCountryPage($json->countryCode, $data);
    } else {
        goToCountryPage("NotFound", $data); // if not found
    }

} else {
    goToCountryPage("NotFound", $data); // if not found
}


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function goToCountryPage($country, $data)
{
    $default = "NotList";
    if (isset($data[$country])) {
        header("Location: $data[$country]");
    } else {
        header("Location: $data[$default]");  // if not in list
    }

}


