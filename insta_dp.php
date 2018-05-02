<?php
/*
Author: 		Sohil M.
Description: 	Have you ever wanted to check the display picture of any account (private/public) in High Definiation. Use this PHP script to see the HD DP of the any user.
Input Param:	username
Output:			HD Image of that user.

Please note that this for educational purpose only.
*/

header("Access-Control-Allow-Origin: *"); //this will allow any page to send GET AJAX request
$user = $_GET["u"]; //taking "USERNAME" from query "u" from current url as variable, e.g https://CURRENTURL.com/THISFILE.php?u=USERNAME
$userPageSourceCode = file_get_contents("https://www.instagram.com/".$user); //getting source code of the user profile instagram page

// Here we are creating DOMDocument to fetch the required info.
$doc = new DOMDocument();
$doc->loadHTML($userPageSourceCode);
$xpath = new DOMXPath($doc);
$js = $xpath->query('//body/script[@type="text/javascript"]')->item(0)->nodeValue;
$start = strpos($js, '{');
$end = strrpos($js, ';');
$json = substr($js, $start, $end - $start);
$requiredData = json_decode($json, true);

$userID = $requiredData["entry_data"]["ProfilePage"][0]["graphql"]["user"]["id"];

$userInnerContent = file_get_contents('https://i.instagram.com/api/v1/users/'.$userID.'/info/');
$userInnerData = json_decode($userInnerContent, true);

$profilePicURL =  $userInnerData['user']['hd_profile_pic_url_info']['url'];

echo "<img src='".$profilePicURL."'/>"; //It will display full HD Picture.
?>