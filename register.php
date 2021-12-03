<?php
    // include db!
    include "./common/db-connect.php";

    // header!
    include "./common/header.php";

    // declare variables!
    $status = false;
    $response = "";
    $name = "";
    $email = "";
    $phone = "";
    $password = "";
    $encPassword = "";
    $salt = uniqid(); // to generate an unique string!
    $createdAt = date('m-d-Y H:i'); // to get todays date!
    $lastUpdatedOn = date('d-m-Y H:i');
    // get form data!
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
    }

    if(isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    if(isset($_POST['phone'])) {
        $phone = $_POST['phone'];
    }

    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    // check if data is available!
    if($name != "" && $email != "" && $phone != "" && $password != "") {

        // check if user exists or not!
        $checkUser = "SELECT * FROM `register` WHERE `email` = '$email'";
        $checkUserRes = mysqli_query($conn,$checkUser) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkUserRes) > 0) {

            $status = false;
            $response = "User already exists!";

        } else {

            // encrypting password!
            $encPassword = md5(md5($password).md5($salt));

            // store the data in the db!
            $insertUser = "INSERT INTO `register`(`name`, `email`, `phone`, `password`, `salt`, `createdAt`,`lastUpdatedOn`) 
                                        VALUES ('$name','$email','$phone','$encPassword','$salt','$createdAt','$lastUpdatedOn')";
            $insertUserRes = mysqli_query($conn,$insertUser) or die(mysqli_error($conn));

            if($insertUserRes) {

                $status = true;
                $response = "User registered!";

            } else {

                $status = false;
                $response = "Unable to add user!";

            }

        }

    } else {

        $status = false;
        $response = "Please fill all the details!";

    }

    $responseArray = array("status" => $status, "response" => $response);
    // ["status" => true, "response" => "User registered!"]
    echo json_encode($responseArray,JSON_PRETTY_PRINT);