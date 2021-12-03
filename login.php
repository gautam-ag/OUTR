<?php
    // include db connection!
    include "./common/db-connect.php";

    // include header file!
    include "./common/header.php";

    // declare variables!
    $email = "";
    $password = "";
    $salt = "";
    $dbPassword = "";
    $encPassword = "";
    $userLoggedIn = "";
    $status = false;
    $response = "";

    // get form data!
    if(isset($_POST['email'])) {

        $email = $_POST['email'];

    }

    if(isset($_POST['password'])) {

        $password = $_POST['password'];

    }

    // check if the form fields are filled or not!
    if($email != "" && $password != "") {

        // check user exists or not!
        $checkUser = "SELECT * FROM `register` WHERE `email` = '$email'";
        $checkUserRes = mysqli_query($conn,$checkUser) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkUserRes) > 0) {

            // user row!
            $checkUserRow = mysqli_fetch_assoc($checkUserRes);

            // get salt and db password!
            $salt = $checkUserRow['salt'];
            $dbPassword = $checkUserRow['password'];

            // encypt password!
            $encPassword = md5(md5($password).md5($salt));

            if($dbPassword == $encPassword) {

                $status = true;
                $response = "User logged in!";
                $userLoggedIn = $email;

            } else {

                $status = false;
                $response = "Password does not match!";

            }

        } else {

            $status = false;
            $response = "No such user exists!";

        }

    } else {

        $status = false;
        $response = "Please fill all the details!";

    }

    $responseArray = array("status" => $status, "response" => $response, "user" => $userLoggedIn);
    echo json_encode($responseArray,JSON_PRETTY_PRINT);