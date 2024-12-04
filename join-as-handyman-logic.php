<?php
require 'config/database.php';

// get join form data if submit button clicked
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user-id'];
    $avatar = $_FILES['avatar'];
    $skills = $_POST['skills'];
    $other_job = filter_var($_POST['other_job'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $work_days = $_POST['work_days'];
    $work_start_time = filter_var($_POST['work_start_time'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $work_end_time = filter_var($_POST['work_end_time'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $work_location = filter_var($_POST['work_location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $profile_description = filter_var($_POST['profile_description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate inputs
    if(!$avatar['name']) {
        $_SESSION['join'] = "Please choose a Profile Picture";
    } elseif (!$skills) {
        $_SESSION['join'] = "No Skills selected";
    } elseif (!$work_days) {
        $_SESSION['join'] = "Select minimum one work day";
    } elseif (!$work_start_time) {
        $_SESSION['join'] = "Work hours not specified";
    } elseif (!$work_end_time) {
        $_SESSION['join'] = "Work hours not specified";
    } elseif (!$work_location) {
        $_SESSION['join'] = "Preferred Work Location not specified";
    } elseif (!$profile_description) {
        $_SESSION['join'] = "Please provide a Profile description";
    } else {
        // rename avatar
        $uniq_id = uniqid('avt_');
        $avatar_name = $uniq_id . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = 'images/' . $avatar_name;
        // validate image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);
        if (!in_array($extension, $allowed_files)) {
            $_SESSION['join']="Image should be PNG, JPG or JPEG";
        } elseif ($avatar['size'] > 1048576) { //check if image too large (1MB+)
            $_SESSION['join']="Image size should be less than 1 MB";
        }
    }

    // reload on error
    if (isset($_SESSION['join'])) {
        // pass entered data back to join form
        $_SESSION['join-data'] = $_POST;
        header('location: ' . ROOT_URL . 'join-as-handyman.php');
        die();
    } else {
        //upload avatar
        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
        // insert profile data
        $insert_profile_query = "INSERT INTO handyman_profiles (user_id, profile_picture_url, other_job, work_start_time, work_end_time, work_location, profile_description) VALUES ($user_id, '$avatar_destination_path', '$other_job', '$work_start_time', '$work_end_time', '$work_location', '$profile_description')";
        // get the newly inserted profile_id
        if (mysqli_query($connection, $insert_profile_query)) {
            $profile_id = mysqli_insert_id($connection);
            // set or override session for profile_id
            $_SESSION['profile-id'] = $profile_id;
        }
        // insert work days
        foreach ($work_days as $day) {
            $insert_work_days_query = "INSERT INTO handyman_work_days (profile_id, day_of_week) VALUES ($profile_id, '$day')";
            mysqli_query($connection, $insert_work_days_query);
        }
        // insert skills 
        foreach ($skills as $skill) {
            $insert_skills_query = "INSERT INTO handyman_skills (profile_id, skill_id) VALUES ($profile_id, '$skill')";
            mysqli_query($connection, $insert_skills_query);
        }
        // update user-is-handyman flag in users table
        $query = "UPDATE users SET is_handyman = 1 WHERE user_id = $user_id";
        mysqli_query($connection, $query);

        // redirect to professional-info on success
        if (!mysqli_errno($connection)) {
            $_SESSION['join-success'] = "Join successfull";
            header('location: ' . ROOT_URL . 'admin/professional-info.php');
            die();
        }
    }

} else {
    // bounce back to signin page if join button not clicked
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}