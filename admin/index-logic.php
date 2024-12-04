<?php
require 'config/database.php';

// get form data if submit button is clicked
if (isset($_POST['submit'])) {
    $user_id = (int) filter_var($_SESSION['user-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ph_pattern = "/^[789]\d{9}$/";
    $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // unchanged data
    $old_name = $_SESSION['full_name'];
    unset($_SESSION['full_name']);
    $old_phone = $_SESSION['phone_number'];
    unset($_SESSION['phone_number']);
    $old_email = $_SESSION['email'];
    unset($_SESSION['email']);
    
    // validate inputs
    if (!$full_name) {
        $_SESSION['index'] = 'Name cannot be empty';
    } elseif (!preg_match($ph_pattern, $phone_number)) {
        $_SESSION['index'] = 'Enter a valid phone No.';
    } elseif (!$email) {
        $_SESSION['index'] = 'Enter a valid email';
    } elseif (!$password) {
        $_SESSION['index'] = 'Please confirm your password';
    } elseif (strlen($password) < 8) {
        $_SESSION['index'] = 'Password incorrect';
    } else {
        // verify password
        $password_query = "SELECT password_hash from users WHERE user_id = $user_id";
        $password_result = mysqli_query($connection, $password_query);
        $db_password = mysqli_fetch_column($password_result);
        if (password_verify($password, $db_password)) {
            // check duplicate phone no. or mail
            $user_check_query = "SELECT * FROM users WHERE (phone_number='$phone_number' OR email='$email') AND user_id != $user_id";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['index'] = 'Phone No. or Email is already in use!';
            }
        } else {
            $_SESSION['index'] = 'Password incorrect';
        }
    }

    // reload on error
    if (isset($_SESSION['index'])) {
        header('location: ' . ROOT_URL . 'admin/index.php');
        die();
    } else {
        // check for change
        $update_fields = array();
        if ($old_name != $full_name) {
            $update_fields[] = "full_name = '$full_name'";
        }
        if ($old_phone != $phone_number) {
            $update_fields[] = "phone_number = '$phone_number'";
        }
        if ($old_email != $email) {
            $update_fields[] = "email = '$email'";
        }
        // check if new password is set
        if ($new_password) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_fields[] = "password_hash = '$new_password_hash'";
        }

        // insert data
        if (count($update_fields) > 0) {
            $update_user_query = "UPDATE users SET " . implode(", ", $update_fields) . " WHERE user_id = $user_id";
            $upate_user_result = mysqli_query($connection, $update_user_query);
        }
        // redirect to login page on success
        if (!mysqli_errno($connection)) {
            $_SESSION['index-success'] = "Successfully updated";
            header('location: ' . ROOT_URL . 'admin/index.php');
            die();
        }
    }

} else {
    // bounce back to index page if submit button not clicked
    header('location: ' . ROOT_URL . 'admin/index.php');
    die();
}