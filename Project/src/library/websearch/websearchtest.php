<?php
require 'google-search-results.php';
require 'restclient.php';

$query = [
    "engine" => "google_scholar",
    "q" => "biology",
];

$search = new GoogleSearchResults('697836773f8cb07bad07947da490499d1900d2df73c183ee405c2d112e95cc18');
$result = $search->get_json($query);
$organic_results = $result->organic_results;

// print_r($organic_results[1]->title);
// print_r($organic_results[1]->snippet);
// $summary_arr = explode("-", ($organic_results[1]->publication_info)->summary);
// print_r($summary_arr[0]);
// print_r($organic_results[1]->link);

for ($i = 0; $i < 5; $i++) {
    #explode function is used to seperate the authors from the rest of the filler content in the displayed link which is seperated by a hyphen
    $summary_arr = explode("-", ($organic_results[$i]->publication_info)->summary);
    print_r("Search result: title - " . $organic_results[$i]->title . ",<br> description - " . $organic_results[$i]->snippet . ",<br> authors - " . $summary_arr[0] . ",<br> link - " . $organic_results[$i]->link . "<br><br>");
};
