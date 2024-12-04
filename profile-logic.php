<?php
require 'config/database.php';

$profile_id = (int) filter_var($_SESSION['profile-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user_id = (int) filter_var($_SESSION['user-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// get rating from database if exists
$query = "SELECT rating FROM handyman_rating WHERE user_id = $user_id AND profile_id = $profile_id";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $old_rating = (int) $row['rating'];
}

// get rating when submit clicked
if (isset($_POST['submit'])) {
    $rating = (int) filter_var($_POST['rating'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // validate input
    if (empty($rating)) {
        $_SESSION['profile'] = "You haven't choosen a rating.";
    } else {
        // update rating if already rated
        if (isset($old_rating) && $old_rating > 0) {
            $query = "UPDATE handyman_rating SET rating = $rating WHERE user_id = $user_id AND profile_id = $profile_id";
            $result = mysqli_query($connection, $query);
        } else {
            // insert data
            $query = "INSERT INTO handyman_rating (user_id, profile_id, rating) VALUES ($user_id, $profile_id, $rating)";
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