<?php
session_start();
if (isset($_SESSION['student'])) {
    unset($_SESSION['student']);
    session_unset();
    session_destroy(); //Destroy session
    header('Location: studentlogin.php'); //Brings user back to home page
}