<?php
session_start();
unset($_SESSION['user']);	//Remove session variables
session_destroy();			//Destroy session
header("Location: studentlogin.html");	//Brings user back to home page
?>