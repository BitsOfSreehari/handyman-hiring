<?php
require 'config/database.php';

// get rating from database if exists
$user_id = $_SESSION['user-id'];
$profile_id = $_SESSION['profile-id'];
$query = "SELECT rating FROM handyman_rating WHERE user_id = $user_id AND profile_id = '$profile_id'";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $old_rating = (int) $row['rating'];
    var_dump($old_rating);
}

// get rating when submit clicked
if (isset($_POST['submit'])) {
    $user_id = (int) $_SESSION['user-id'];
    $profile_id = (int) $_SESSION['profile-id'];
    var_dump($user_id);
    var_dump($profile_id);
    $rating = (int) filter_var($_POST['rating'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    var_dump($rating);
    // validate input
    if (empty($rating)) {
        $_SESSION['profile'] = "Please choose a rating.";
    } else {
        // update rating if already rated
        if (isset($old_rating) && $old_rating > 0) {
            $query = "UPDATE handyman_rating SET rating = $rating WHERE user_id = '$user_id' AND profile_id = '$profile_id'";
            $result = mysqli_query($connection, $query);
        } else {
            // insert data
            $query = "INSERT INTO handyman_rating (user_id, profile_id, rating) VALUES ('$user_id', '$profile_id', '$rating')";
            $result = mysqli_query($connection, $query);
        }
        // reload on success
        if (!mysqli_errno($connection)) {
            $_SESSION['rating'] = "Successfully submitted.";
            header('location: ' . ROOT_URL . 'profile.php?profile_id=' . $profile_id);
            die();
        }
    }
} else {
    // bounce back if submit button not clicked
    header('location: ' . ROOT_URL);
    die();
}