<?php
require 'config/database.php';

// get signup form data if signup button clicked
if (isset($_POST['submit'])) {
    $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ph_pattern = "/^[789]\d{9}$/";
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $create_password = filter_var($_POST['create_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate inputs
    if (!$full_name) {
        $_SESSION['signup'] = 'Please enter your Full Name';
    } elseif (!preg_match($ph_pattern, $phone_number)) {
        $_SESSION['signup'] = 'Please enter a valid Phone No.';
    } elseif (!$email) {
        $_SESSION['signup'] = 'Please enter a valid Email';
    } elseif (!$create_password) {
        $_SESSION['signup'] = 'Please choose a Password';
    } elseif (strlen($create_password) < 8) {
        $_SESSION['signup'] = 'Password should be 8+ characters';
    } elseif (!$confirm_password) {
        $_SESSION['signup'] = 'Please confirm your Password';
    } else {
        // if passwords do not match
        if ($create_password !== $confirm_password) {
            $_SESSION['signup'] = 'Passwords do not match';
        } else {
            // check duplicate phone no. or mail
            $user_check_query = "SELECT * FROM users WHERE phone_number='$phone_number' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = 'Phone No. or Email is already in use!';
            } else {
            // hash password
            $password_hash = password_hash($create_password, PASSWORD_DEFAULT);
            }
        }
    }

    // reload on error
    if (isset($_SESSION['signup'])) {
        // pass entered data back to signup form
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert data
        $insert_user_query = "INSERT INTO users (full_name, phone_number, email, password_hash) VALUES ('$full_name', '$phone_number', '$email', '$password_hash');";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            $_SESSION['signup-success'] = "Registraion successfull. Please Log in";
            // redirect to login page on success
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }

} else {
    // bounce back to signup page if signup button not clicked
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}