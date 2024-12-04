<?php
require 'config/database.php';

// get profile id and user id
$profile_id = (int) $_SESSION['profile-id'];
$user_id = (int) $_SESSION['user-id'];

// get avatar if new is set
if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    // validate inputs
    if(!$avatar['name']) {
        $_SESSION['professional-info'] = "Please choose a Profile Picture";
    } else {
        // rename avatar
        $uniq_id = uniqid('avt_');
        $avatar_name = $uniq_id . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = '../images/' . $avatar_name;
        $avatar_real_path = 'images/' . $avatar_name;
        // validate image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $avatar_name);
        $extension = end($extension);
        if (!in_array($extension, $allowed_files)) {
            $_SESSION['professional-info']="Image should be PNG, JPG or JPEG";
        } elseif ($avatar['size'] > 1048576) { //check if image too large (1MB+)
            $_SESSION['professional-info']="Image size should be less than 1 MB";
        }
        // reload on error
        if (isset($_SESSION['professional-info'])) {
            header('location: ' . ROOT_URL . 'admin/professional-info.php');
            die();
        } else {
        //upload avatar
        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
        // update profile url
        $update_profile_url_query = "UPDATE handyman_profiles SET profile_picture_url = '$avatar_real_path' WHERE profile_id = $profile_id";
        mysqli_query($connection, $update_profile_url_query);
        }

        // redirect to professional-info on success
        if (!mysqli_errno($connection)) {
            $_SESSION['professional-info-success'] = "Successfully updated profile picture";
            header('location: ' . ROOT_URL . 'admin/professional-info.php');
            die();
        }
    }
}


// get form data if submit button clicked
if (isset($_POST['submit'])) {
    $skills = $_POST['skills'];
    $other_job = filter_var($_POST['other_job'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $work_days = $_POST['work_days'];
    $work_start_time = filter_var($_POST['work_start_time'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $work_end_time = filter_var($_POST['work_end_time'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $work_location = filter_var($_POST['work_location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $profile_description = filter_var($_POST['profile_description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate inputs
    if (!$skills) {
        $_SESSION['professional-info'] = "No Skills selected";
    } elseif (!$work_days) {
        $_SESSION['professional-info'] = "Select minimum one work day";
    } elseif (!$work_start_time) {
        $_SESSION['professional-info'] = "Work hours not specified";
    } elseif (!$work_end_time) {
        $_SESSION['professional-info'] = "Work hours not specified";
    } elseif (!$work_location) {
        $_SESSION['professional-info'] = "Preferred Work Location not specified";
    } elseif (!$profile_description) {
        $_SESSION['professional-info'] = "Please provide a Profile description";
    } else {
        // update profile
        $update_profile_query = "UPDATE handyman_profiles SET other_job = '$other_job', work_start_time = '$work_start_time', work_end_time = '$work_end_time', work_location = '$work_location', profile_description = '$profile_description' WHERE profile_id = $profile_id";
        mysqli_query($connection, $update_profile_query);
        // update skills
        $old_skills_query = "SELECT skill_id FROM handyman_skills WHERE profile_id = $profile_id";
        $old_skills_result = mysqli_query($connection, $old_skills_query);
        $old_skills = mysqli_fetch_all($old_skills_result);
        $old_skills = array_column($old_skills, 0); // profile's skills from db
        $deleted_skills = array_diff($old_skills, $skills); // de-selected skills
        $added_skills = array_diff($skills, $old_skills); // newely selected skills
        foreach ($deleted_skills as $deleted_skill) { // delete de-selected skills
            $delete_skills_query = "DELETE FROM handyman_skills WHERE profile_id = $profile_id AND skill_id = $deleted_skill";
            mysqli_query($connection, $delete_skills_query);
        }
        foreach ($added_skills as $added_skill) { // add newely selected skills
            $add_skills_query = "INSERT INTO handyman_skills (profile_id, skill_id) VALUES ($profile_id, $added_skill)";
            mysqli_query($connection, $add_skills_query);
        }
        // update work days
        $old_days_query = "SELECT day_of_week FROM handyman_work_days WHERE profile_id = $profile_id";
        $old_days_result = mysqli_query($connection, $old_days_query);
        $old_days = mysqli_fetch_all($old_days_result);
        $old_days = array_column($old_days, 0); // profile's days from db
        $deleted_days = array_diff($old_days, $work_days); // de-selected days
        $added_days = array_diff($work_days, $old_days); // newely selected days
        foreach ($deleted_days as $deleted_day) { // delete de-selected days
            $delete_days_query = "DELETE FROM handyman_work_days WHERE profile_id = $profile_id AND day_of_week = $deleted_day";
            mysqli_query($connection, $delete_days_query);
        }
        foreach ($added_days as $added_day) { // add newely selected days
            $add_days_query = "INSERT INTO handyman_work_days (profile_id, day_of_week) VALUES ($profile_id, $added_day)";
            mysqli_query($connection, $add_days_query);
        }
    }

    // reload on error
    if (isset($_SESSION['professional-info'])) {
        header('location: ' . ROOT_URL . 'admin/professional-info.php');
        die();
    }

    // redirect to professional-info on success
    if (!mysqli_errno($connection)) {
        $_SESSION['professional-info-success'] = "Update successfull";
        header('location: ' . ROOT_URL . 'admin/professional-info.php');
        die();
    }

} else {
    // bounce back to professional info if submit button is not clicked
    header('location: ' . ROOT_URL . 'admin/professional-info.php');
    die();
}