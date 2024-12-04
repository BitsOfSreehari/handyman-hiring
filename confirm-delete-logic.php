<?php
require 'config/database.php';

if (isset($_POST['confirm'])) {
    $delete_type = filter_var($_SESSION['delete-type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    unset($_SESSION['delete-type']);
    $delete_item_id = filter_var($_SESSION['delete-item-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    unset($_SESSION['delete-type-id']);
    $delete_item_name = $_SESSION['delete-item-name'];
    unset($_SESSION['delete-item-name']);
    $back_url = $_SESSION['back-url'];
    unset($_SESSION['back-url']);
    switch ($delete_type) {
        case 'Category':
            $delete_query = "DELETE FROM skills WHERE skill_id = $delete_item_id";
            break;
        case 'Profile':
            $delete_query = "DELETE FROM handyman_profiles WHERE profile_id = $delete_item_id";
            $update_user_role_query = "UPDATE users SET is_handyman = 0 WHERE user_id =" . $_SESSION['user-id'];
            break;
        case 'Account':
            $delete_query = "DELETE FROM users WHERE user_id = $delete_item_id";
            break;
    }

    if (isset($delete_query)) {
        mysqli_query($connection, $delete_query);
    }

    if (isset($update_user_role_query)) {
        mysqli_query($connection, $update_user_role_query);
    }

    if ($delete_query === null || mysqli_errno($connection) !== 0) {
        $_SESSION['delete'] = "An error occured!";
        header('location: ' . $back_url);
        die();
    } else {
        $_SESSION['delete-success'] = "$delete_type - $delete_item_name deleted successfully";
        header('location: ' . $back_url);
        die();
    }
}