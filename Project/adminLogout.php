<?php
session_start();
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
    session_unset();
    session_destroy(); //Destroy session
    header('Location: adminlogin.php'); //Brings user back to home page
}