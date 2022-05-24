<?php
session_start();
unset($_SESSION['user']);	//Destroy session
header("Location: studentlogin.html");	//Brings user back to home page
?>