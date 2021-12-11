<?php
    // db connection
    include "./db.php";
    
    date_default_timezone_set('Asia/Kolkata');

    // declaring variables!
    $name = "";
    $email = "";
    $domain1 = "";
    $domain2 = "";
    $branch = "";
    $year = "";
    $password = "";
    $encPassword = "";
    $salt = uniqid();
    $createdOn = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');
    $registrationNo = "";
    $skills = "";

    // getting form data!
    if(isset($_POST['name'])){

        $name = $_POST['name'];
    
    }

    if(isset($_POST['email'])){
    
        $email = $_POST['email'];
    
    }

    if(isset($_POST['domain1'])){
    
        $domain1 = $_POST['domain1'];
    
    }

    if(isset($_POST['domain2'])) {

        $domain2 = $_POST['domain2'];

    }

    if(isset($_POST['branch'])){
    
        $branch = $_POST['branch'];
    
    }

    if(isset($_POST['year'])){
    
        $year = $_POST['year'];
    
    }

    if(isset($_POST['password'])){
    
        $password = $_POST['password'];
    
    }

    if(isset($_POST['skills'])){

        $skills = $_POST['skills'];

    }

    if(isset($_POST['registrationNo'])){

        $registrationNo = $_POST['registrationNo'];

    }

    if($name != "" && $email != "" && $domain1 != "" && $branch != "" && $year != "" && $password != "" && $skills != "" && $registrationNo != ""){

        // if user already exists!
        $checkUser = "SELECT * FROM `users` WHERE `email` = '$email'";
        $checkUserRes = mysqli_query($conn,$checkUser) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkUserRes) > 0) {

            header('Location: ../index.php?message=User already exists. Login!#page2/2');

        } else {

            // generate an encrypted password!
            $encPassword = md5(md5($password).md5($salt));
            
            // register user!
            $registerUser = "INSERT INTO `users` (`name`, `email`, `domain1`, `domain2`, `branch`, `year`, `password`,`salt`,`createdOn`,`lastUpdatedOn`, `skills`,`registrationNo`) 
                                            VALUES ('$name', '$email', '$domain1', '$domain2', '$branch', '$year', '$encPassword','$salt','$createdOn','$lastUpdatedOn', '$skills', '$registrationNo')";

            $registerUserRes = mysqli_query($conn, $registerUser) or die(mysqli_error($conn));

            if($registerUserRes) {

                header('Location: ../index.php?message=User registered successfully. Login Now!#page2/2');

            } else {

                header('Location: ../index.php?message=Unable to register user!#page2');

            }

        }

        
    }else {
        
        header('Location: ../index.php?message=Please fill all the details!#page2');

    }
?>