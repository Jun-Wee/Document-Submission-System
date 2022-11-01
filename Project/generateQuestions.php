<?php
session_start();

if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
} else {
    $extractedLimitedText = $_SESSION["questGen"];
    $submissionId = $_SESSION["subId"];

    $url = "http://18.213.73.237/question/";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Accept: application/json",
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = json_encode(array(
        'submissionId' => $submissionId, 'extractedText' => utf8_encode($extractedLimitedText)

    ), JSON_FORCE_OBJECT);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $resp = curl_exec($curl);

    $q = json_decode($resp);

    curl_close($curl);

    $_SESSION["questionGenerated"] = serialize($q);

    header("Location: questions.php");
}
