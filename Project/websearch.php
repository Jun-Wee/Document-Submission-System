<?php
//Load Composer's autoloader
require 'src/library/websearch/google-search-results.php';
require 'src/library/websearch/restclient.php';

//include
include "classes/database.php";
require "classes/webSearchTable.php";

session_start();

$db = new Database();
$websearch = new WebSearchTable($db);

$title = $_SESSION['title'];
$limitedText = $_SESSION['questGen'];
$subId = $_SESSION['subId'];
$secret_api_key = '697836773f8cb07bad07947da490499d1900d2df73c183ee405c2d112e95cc18';

echo $title;

$query = [
  "engine" => "google_scholar",
  "q" => $title,
];

$search = new GoogleSearchResults($secret_api_key);
$result = $search->get_json($query);
$organic_results = $result->organic_results;

for ($i = 0; $i < 5; $i++) {
  #explode function is used to seperate the authors from the rest of the filler content in the displayed link which is seperated by a hyphen
  $summary_arr = explode("-", ($organic_results[$i]->publication_info)->summary);
  print_r("Search result: title - " . $organic_results[$i]->title . ",<br> description - " . $organic_results[$i]->snippet . ",<br> authors - " . $summary_arr[0] . ",<br> link - " . $organic_results[$i]->link . "<br><br>");
};

echo $websearch->Add($organic_results, $subId);

$_SESSION['questGen'] = $limitedText;
$_SESSION['subId'] = $subId;
header("Location: generateQuestions.php");
