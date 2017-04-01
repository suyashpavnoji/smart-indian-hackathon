<?php

$CustomerNumber = $_GET['CustomerNumber'];
if(!isset($CustomerNumber))
{
   json_encode(array("error" => "NumberNotProvided"));
}
else {

$post_data = array(
    'From' => $CustomerNumber,
    'CallerId' => "02233835952",
    'Url' => "http://my.exotel.in/exoml/start/SmartIndianHackathon",
    'CallType' => "trans"
);

$exotel_sid = "digix"; // Your Exotel SID - Get it here: http://my.exotel.in/Exotel/settings/site#exotel-settings
  $exotel_token = "46a3091e97bd1466c0b27f78ee72b9516dc609ec"; // Your exotel token - Get it here: http://my.exotel.in/Exotel/settings/site#exotel-settings

$url = "https://".$exotel_sid.":".$exotel_token."@twilix.exotel.in/v1/Accounts/".$exotel_sid."/Calls/connect";

$ch = curl_init();
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FAILONERROR, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));

$http_result = curl_exec($ch);
$error = curl_error($ch);
$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);

curl_close($ch);

print "Response = ".print_r($http_result);

}

?>
