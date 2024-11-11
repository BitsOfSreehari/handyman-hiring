<?php
require 'config/database.php';

// check login status
if (!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

// check if the user exists in the database
$user_id = $_SESSION['user-id'];
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($connection, $sql);
// if the user doesn't exist, destroy the session and redirect
if (mysqli_num_rows($result) == 0) {
    session_unset();
    session_destroy();
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

// update user role sessions
$fetch_user_role_query = "SELECT is_handyman, is_admin FROM users WHERE user_id='$user_id'";
$fetch_user_role_result = mysqli_query($connection, $fetch_user_role_query);
$user_role_record = mysqli_fetch_assoc($fetch_user_role_result);
$user_is_handyman = $user_role_record['is_handyman'];
$user_is_admin = $user_role_record['is_admin'];
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handyman</title>

    <!-- CUSTOM STYLE SHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- FONTAWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- GOOGLE FONT(Patrick Hand SC) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Patrick+Hand+SC&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <a href="<?= ROOT_URL ?>"><span>Handyman<small>.com</small></span></a>
        </div>
    </header>
