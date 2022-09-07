<?php
//Load Composer's autoloader
require "src/library/websearch/vendor/autoload.php";

//include
require "titlepage.php";
include "classes/database.php";
require "classes/webSearchTable.php";

$db = new Database();
$websearch = new webSearchTable();

$title = $_POST["title"];	
$title = $websearch->sanitise_input($title);
$err_msg = "";

if ($title=="") 
{
	$err_msg .= "<p>Please enter title.</p>";
}	
else if (!preg_match("/^[a-zA-Z]$/",$title))
{
	$err_msg .= "<p>Title can only contain alpha characters.</p>";
}	

if ($err_msg!=""){
  echo $err_msg;
}

//perform search
$queryString = http_build_query([
  'api_key' => '45D285BCD4564CA89DB02392F607A231',
  'engine' => 'google',
  'search_type' => 'scholar',
  'q' => $title,
  'page' => '1'
]);

# make the http GET request
$ch = curl_init(sprintf('%s?%s', 'https://api.serpwow.com/live/search', $queryString));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
# the following options are required if you're using an outdated OpenSSL version
# more details: https://www.openssl.org/blog/blog/2021/09/13/LetsEncryptRootCertExpire/
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 180);

$api_result = curl_exec($ch);
curl_close($ch);

# print the JSON response
$data = json_decode($api_result);

# print the JSON response from SerpWow
$data = json_decode($api_result);

$results = $data->scholar_results;
  
print("THE RESULTS <br>");

for( $x=0; $x< 5; $x++)
{
  $search = $results[$x];

  #explode function is used to seperate the authors from the rest of the filler content in the displayed link which is seperated by a hyphen
  $splarr = explode("-",$search->displayed_link);
    print_r("Search result: title - ".$search->title.",<br> description - ". $search->snippet .",<br> authors - ".$splarr[0].",<br> link - ". $search->link."<br><br>");
};
  #explore the below link to understand web search results 
  #https://www.serpwow.com/docs/search-api/results/google/search
?>