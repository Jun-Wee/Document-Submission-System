<!-- Description: System function gathers all methods to be used in the system -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Date: 25th May 2022 -->
<!-- Validated: =-->
<?php
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
        if (checkNotEmpty($input)) {
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

     function ChkEmailPasswordForLogin($emailInput, $passwordInput, $db)
    {
        $email = $emailInput;
        $login_password = $passwordInput;
        $login_msg = "";
        $LoginOK = false;
        $error = "email";
        $profile = "";

        [$login_msg, $LoginOK, $email] = chkEmail($email);

        if ($LoginOK) {
            // Create connection
            $db->createConnection();

            $email = mysqli_escape_string($db->getConnection(), $email);
            $login_password = mysqli_escape_string($db->getConnection(), $login_password);
            $login_password = substr($login_password, 0, 20);

            // check if the input email already exists or not by getting them from the database
            $sql = "SELECT * FROM users WHERE Role = 'Student' AND Email = ?";

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
                    $profile = array($row[3], $row[1], $row[2], $row[0], $row[5]);
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
?>