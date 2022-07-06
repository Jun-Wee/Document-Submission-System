<!-- Description: student upload backend logic -->
<!-- Author: Jun Wee Tan -->
<!-- Contributor:-->
<!-- Date: 26th June 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";
include "classes/database.php";

session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
} else {
    $student = unserialize($_SESSION['student']);
}

if (isset($_POST['submit'])) { 
    $file = $_FILES['file']; //gets all the info from the uploaded file
    //print_r($file); //testing for file superglobal
    $filename = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];

    $fileExtract = explode('.',$filename);  //split by dot
    $fileActualExt = strtolower(end($fileExtract)); //take only the file extension

    $allowedType = 'pdf';

    //control submission propeties
    if ($fileActualExt == $allowedType) //check file type
    {
            if ($fileError === 0) //check file error
            {  
                if ($fileSize < 5000000) //limit file size to 5gb / 5000000kb
                { 
                    $fileNewName = $student->getName().".". rand(1000,2000).".".$filename;  //file format: studentname.random number.filename
                    $fileDestination = 'StuSubmission/'.$fileNewName;
                    move_uploaded_file($fileTmpName,$fileDestination);
                    header("Location: submission.php?uploadsuccess");  //success upload indicator
                }else 
                {
                    echo "<script type='text/javascript'>alert('Exceed file size limit!');</script>";
                }
            }
            else
            {
                echo "<script type='text/javascript'>alert('There was an error uploading your file, Please try again.');</script>";
            }
    }else
    {
        echo "<script type='text/javascript'>alert('Error file type uploaded!');</script>";
    }

}
?>