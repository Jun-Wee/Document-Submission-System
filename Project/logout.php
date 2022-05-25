<?php
session_start();
unset($_SESSION['student']);	//Destroy session
header("Location: studentlogin.php");	//Brings user back to home page
?>