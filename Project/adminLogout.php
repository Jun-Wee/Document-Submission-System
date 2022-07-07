<?php
session_start();
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
}
if(isset($_SESSION['convenor'])){
    unset($_SESSION['convenor']);
}
session_unset();
session_destroy(); //Destroy session
header('Location: adminLogin.php'); //Brings user back to home page