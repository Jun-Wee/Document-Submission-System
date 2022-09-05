<?php

namespace SystemFunction;

class System
{
    function checkNotEmpty($field)
    {
        if (empty($field) == false) {
            return true;
        } else {
            return false;
        }
    }


    function chkEmail($input)
    {
        $emailOK = false;
        $email_msg = "";
        $email = $input;
        // validate the format of the email using regular expresssion
        if ($this->checkNotEmpty($input)) {
            $email = strval($email);
            // StudentID@student.swin.edu.au
            $pattern = "/^([0-9]+)@student\.swin\.edu\.au$/";
            if (preg_match($pattern, $email) == 1) {
                $emailOK = true;
            } else {
                $emailOK = false;
                $email_msg = "The student email is not valid. Please try again!";
            }
        } else {
            $emailOK = false;
            $email_msg = "Email input cannot be empty. Please try again!";
        }
        return [$email_msg, $emailOK, $email];
    }

    function chkAdminEmail($input)
    {
        $emailOK = false;
        $email_msg = "";
        $email = $input;
        // validate the format of the email using regular expresssion
        if ($this->checkNotEmpty($input)) {
            $email = strval($email);
            // StudentID@student.swin.edu.au
            $pattern = "/^([a-zA-Z0-9_\-\.]+)@swin\.edu\.au$/";
            if (preg_match($pattern, $email) == 1) {
                $emailOK = true;
            } else {
                $emailOK = false;
                $email_msg = "The admin/convenor email is not valid. Please try again!";
            }
        } else {
            $emailOK = false;
            $email_msg = "Email input cannot be empty. Please try again!";
        }
        return [$email_msg, $emailOK, $email];
    }

    function ChkAdminEmailPasswordForLogin($emailInput, $passwordInput, $db)
    {
        $email = $emailInput;
        $login_password = $passwordInput;
        $login_msg = "";
        $LoginOK = false;
        $error = "email";
        $profile = "";
        $role = "";


        [$login_msg, $LoginOK, $email] = $this->chkAdminEmail($email);

        if ($LoginOK) {
            // Create connection
            $db->createConnection();

            $email = mysqli_escape_string($db->getConnection(), $email);
            $login_password = mysqli_escape_string($db->getConnection(), $login_password);
            $login_password = substr($login_password, 0, 20);

            // check if the input email already exists or not by getting them from the database
            $sql = "SELECT * FROM convenors WHERE Email = ? UNION SELECT * FROM admin WHERE Email = ?";

            $prepared_stmt = mysqli_prepare($db->getConnection(), $sql);

            //Bind input variables to prepared statement
            mysqli_stmt_bind_param($prepared_stmt, 'ss', $email, $email);

            //Execute prepared statement
            @mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_num_rows($queryResult);
            if ($row <= 0) {
                $error = "email";
                $login_msg = "Cannot find your account.";
                $LoginOK = false;
                $profile = "";
            } else if ($row == 1) {
                $row = mysqli_fetch_row($queryResult);
                if ($row[3] == $login_password) {
                    $LoginOK = true;
                    $profile = array($row[0], $row[1], $row[2], $row[3], $row[5]);
                    $role = $row[4];
                } else {
                    $error = "password";
                    $login_msg = "Incorrect Password. Please try again.";
                    $LoginOK = false;
                }
            }
            $db->closeConnection();
        }
        return [$login_msg, $LoginOK, $email, $error, $profile, $role];
    }

    function ChkEmailPasswordForLogin($emailInput, $passwordInput, $db)
    {
        $email = $emailInput;
        $login_password = $passwordInput;
        $login_msg = "";
        $LoginOK = false;
        $error = "email";
        $profile = "";

        [$login_msg, $LoginOK, $email] = $this->chkEmail($email);

        if ($LoginOK) {
            // Create connection
            $db->createConnection();

            $email = mysqli_escape_string($db->getConnection(), $email);
            $login_password = mysqli_escape_string($db->getConnection(), $login_password);
            $login_password = substr($login_password, 0, 20);

            // check if the input email already exists or not by getting them from the database
            $sql = "SELECT * FROM students WHERE Email = ?";

            $prepared_stmt = @mysqli_prepare($db->getConnection(), $sql);

            //Bind input variables to prepared statement
            @mysqli_stmt_bind_param($prepared_stmt, 's', $email);

            //Execute prepared statement
            @mysqli_stmt_execute($prepared_stmt);

            // Get resultset
            $queryResult =  @mysqli_stmt_get_result($prepared_stmt)
                or die("<p>Unable to select from database table</p>");

            // Close the prepared statement
            @mysqli_stmt_close($prepared_stmt);

            $row = mysqli_num_rows($queryResult);

            if ($row <= 0) {
                $error = "email";
                $login_msg = "Cannot find your account.";
                $LoginOK = false;
                $profile = "";
            } else if ($row == 1) {
                $row = mysqli_fetch_row($queryResult);
                if ($row[3] == $login_password) {
                    $LoginOK = true;
                    $profile = array($row[0], $row[1], $row[2], $row[3], $row[5]);
                } else {
                    $error = "password";
                    $login_msg = "Incorrect Password. Please try again.";
                    $LoginOK = false;
                }
            }
            $db->closeConnection();
        }
        return [$login_msg, $LoginOK, $email, $error, $profile];
    }

    function checkNewUploadedFile($filename, $fileTmpName, $fileError, $fileSize, $studentName, $unitCode)
    {
        $fileUploadErrorMsg = "";
        $fileExtract = explode('.', $filename);  //split by dot
        $fileActualExt = strtolower(end($fileExtract)); //take only the file extension
        $fileDestination = "";

        $allowedType = 'pdf';

        //control submission properties
        if ($fileActualExt == $allowedType) //check file type
        {
            if ($fileError === 0) //check file error
            {
                if ($fileSize < 3000000) //limit file size to 3gb / 3000000kb
                {
                    $fileNewName = $studentName . "." . rand(1000, 2000) . "." . $filename;  //file format: studentname.random number.filename

                    $file_directory = '/StuSubmission/' . $unitCode . '/' . $studentName . '/';
                    $server_root_directory = '/var/www/html';

                    if (!file_exists($server_root_directory . $file_directory)) {
                        mkdir($server_root_directory . $file_directory, 0777, true);
                    }
                    $fileDestination = $server_root_directory . $file_directory . basename($fileNewName);
                    move_uploaded_file($fileTmpName, $fileDestination);
                } else {
                    $fileUploadErrorMsg = "Exceed file size limit!";
                }
            } else {
                $fileUploadErrorMsg = "There was an error uploading your file, Please try again.";
            }
        } else {
            $fileUploadErrorMsg = "Error file type uploaded!";
        }

        return [$fileUploadErrorMsg, $file_directory . basename($fileNewName)];
    }

    function checkUploadedFile($file, $filename, $fileTmpName, $fileError, $fileSize, $student, $unitCode)
    {
        $file = $_FILES['file']; //gets all the info from the uploaded file
        print_r($file); //testing for file superglobal
        // $filename = $_FILES['file']['name'];
        // $fileTmpName = $_FILES['file']['tmp_name'];
        // $fileError = $_FILES['file']['error'];
        // $fileSize = $_FILES['file']['size'];

        $fileUploadErrorMsg = "";
        $fileExtract = explode('.', $filename);  //split by dot
        $fileActualExt = strtolower(end($fileExtract)); //take only the file extension
        $fileDestination = "";

        $allowedType = 'pdf';

        //control submission properties
        if ($fileActualExt == $allowedType) //check file type
        {
            if ($fileError === 0) //check file error
            {
                if ($fileSize < 3000000) //limit file size to 3gb / 3000000kb
                {
                    $fileNewName = $student->getName() . "." . rand(1000, 2000) . "." . $filename;  //file format: studentname.random number.filename

                    $file_directory = '/StuSubmission/' . $unitCode . '/' . $student->getName() . '/';
                    $server_root_directory = '/var/www/html';

                    echo $file_directory . "\n";

                    if (!file_exists($server_root_directory . $file_directory)) {
                        mkdir($server_root_directory . $file_directory, 0777, true);
                    }

                    $fileDestination = $server_root_directory . $file_directory . basename($fileNewName);

                    echo $fileDestination . "\n";

                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        $fileUploadErrorMsg = "";
                    } else {
                        $fileUploadErrorMsg = "There was an error uploading your file, Please try again!";
                    }
                    //header("Location: submission.php?uploadsuccess");  //success upload indicator
                } else {
                    $fileUploadErrorMsg = "Exceed file size limit!";
                }
            } else {
                $fileUploadErrorMsg = "There was an error uploading your file, Please try again.";
            }
        } else {
            $fileUploadErrorMsg = "Error file type uploaded!";
        }

        return [$fileUploadErrorMsg, $file_directory . basename($fileNewName)];
    }

    // PHP program to pop an alert
    // message box on the screen

    // Function definition
    function function_alert($message)
    {
        // Display the alert box 
        echo "<script>alert('$message');</script>";
    }
}
