<?php
require 'config/database.php';

$selected_login_with = $_SESSION['selected_login_with'];
unset($_SESSION['selected_login_with']);

// get signin form data if signin button is clicked
if (isset($_POST['submit'])) {
    $phone_number = isset($_POST['phone_number']) ? filter_var($_POST['phone_number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate inputs
    if ($selected_login_with === 'ph' && !$phone_number) {
        $_SESSION['signin'] = "Phone No. required";
    } elseif ($selected_login_with === 'mail' && !$email) {
        $_SESSION['signin'] = "Email required";
    } elseif (!$password) {
        $_SESSION['signin'] = "Password required";
    } else {
        // fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE phone_number='$phone_number' OR email='$email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);
        if (mysqli_num_rows($fetch_user_result) === 1) {
            // covert the record into assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password_hash'];
            $user_is_handyman = $user_record['is_handyman'];
            $user_is_admin = $user_record['is_admin'];
            // compare password
            if (password_verify($password, $db_password)) {
                // set session for access control
                $_SESSION['user-id'] = $user_record['user_id'];
                // set session for handyman
                if ($user_is_handyman == 1) {
                    $_SESSION['user-is-handyman'] = 1;
                } else {
                    $_SESSION['user-is-handyman'] = 0;
                }
                // set session for admin
                if ($user_is_admin == 1) {
                    $_SESSION['user-is-admin'] = 1;
                } else {
                    $_SESSION['user-is-admin'] = 0;
                }
                // log user in
                header('location: ' . ROOT_URL);
            } else {
            $_SESSION['signin'] = "Please check your input";
            }
        } else {
            $_SESSION['signin'] = "User not found. Please signup first";
        }
    }

    // reload on error
    if (isset($_SESSION['signin'])) {
        // pass entered data back to signin form
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

} else {
    // bounce back to signin page if signin button not clicked
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}