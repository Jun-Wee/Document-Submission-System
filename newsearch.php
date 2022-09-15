<?php


#require_once( 'C:/xampp/htdocs/xampp/softwareproj/vendor/autoload.php');

require_once('C:/xampp/new/htdocs/Web Search/vendor/serpapi/google-search-results-php/google-search-results.php') ;
require_once('C:/xampp/new/htdocs/Web Search/vendor/serpapi/google-search-results-php/restclient.php'); 

// *********************  if it is not submitted from submission, redirection
if (!isset($_POST["submit"])) {//it is not triggered by document submission button(eg. by direct URL access)
		header("location:titlepage.php");
		exit();
	}
	
// **********************  validate form  
$err_msg="";


function sanitise_input($data) {
   		$data = trim($data);
   		$data = stripslashes($data);
   		$data = htmlspecialchars($data);
   		return $data;
}


$title=$_POST["title"];	

$title=sanitise_input($title);


if ($title=="") {
	$err_msg .= "<p>Please enter title.</p>";
	}
else if (!preg_match('/^[a-zA-Z\s]+$/',$title)) {
		$err_msg .= "<p>Title can only contain alpha characters.</p>";
}	

if ($err_msg!=""){
	echo $err_msg;
	exit();
}

$query = [
    "engine" => "google_scholar",
    "q" => $title,
    "hl" => "en",
	"gl" => "au",
	"google_domain" => "google.com.au",
    "start" => "0",
    "num" => "5"
   ];

$search = new GoogleSearchResults('697836773f8cb07bad07947da490499d1900d2df73c183ee405c2d112e95cc18');
$result = $search->get_json($query);
$organic_results = $result->organic_results;

  
print("THE RESULTS <br>");

for( $x=0; $x< 5; $x++)
{
  $search = $organic_results[$x];

  #explode function is used to seperate the authors from the rest of the filler content in the displayed link which is seperated by a hyphen
  $splarr = explode("-",$search->publication_info->summary);
    print_r("Search result: title - ".$search->title.",<br> description - ". $search->snippet .",<br> authors - ".$splarr[0].",<br> link - ". $search->link."<br><br>");
  
};



 ?>