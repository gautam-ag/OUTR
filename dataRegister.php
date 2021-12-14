<?php
    // db connection
    include "./db.php";
    
    date_default_timezone_set('Asia/Kolkata');

    // declaring variables!
    $name = "";
    $email = "";
    $registrationNo = "";
    $password = "";
    $encPassword = "";
    $salt = uniqid();
    $createdAt = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');

    // getting form data!
    if(isset($_POST['name'])){

        $name = $_POST['name'];
    
    }

    if(isset($_POST['email'])){
    
        $email = $_POST['email'];
    
    }

    if(isset($_POST['registrationNo'])){
    
        $registrationNo = $_POST['registrationNo'];
    
    }

    if(isset($_POST['password'])) {

        $password = $_POST['password'];

    }

    

    if($name != "" && $email != "" && $registrationNo != "" && $password!= ""){

        // if user already exists!
        $checkUser = "SELECT * FROM `registration` WHERE `email` = '$email'";
        $checkUserRes = mysqli_query($conn,$checkUser) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkUserRes) > 0) {

            header('Location: ../index.php?message=User already exists. Login!#page2/2');

        } else {

            // generate an encrypted password!
            $encPassword = md5(md5($password).md5($salt));
            
            // register user!
            $registerUser = "INSERT INTO `registration` (`name`, `email`, `registrationNo`, `password`, `salt`,`createdAt`,`lastUpdatedOn`) 
                                            VALUES ('$name', '$email', '$registrationNo', '$encPassword', '$salt','$createdAt','$lastUpdatedOn')";

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
