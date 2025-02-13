<?php
require 'config/database.php';

// redirect to personal info if user is not an admin
if ($_SESSION['user-is-admin'] != 1) {
    header('location: ' . ROOT_URL . 'admin/manage-user.php');
}

// get user id and redirect if not set
if (isset($_GET['user-id'])) {
    $user_id = (int) $_GET['user-id'];
} else {
    header('location: ' . ROOT_URL . 'admin/manage-user.php');
}

// get data from user table
$fetch_user_query = "SELECT full_name, phone_number, email, is_handyman, is_admin, created_at, updated_at FROM users WHERE user_id = $user_id";
$fetch_user_result = mysqli_query($connection, $fetch_user_query);
$user_data = mysqli_fetch_assoc($fetch_user_result);

// get data from profiles table
$fetch_profile_query = "SELECT profile_id, profile_picture_url, other_job, work_start_time, work_end_time, work_location, profile_description FROM handyman_profiles WHERE user_id = $user_id";
$fetch_profile_result = mysqli_query($connection, $fetch_profile_query);
$profile_data = mysqli_fetch_assoc($fetch_profile_result);

if (mysqli_num_rows($fetch_profile_result) > 0) {
    // get skills and assign the array to a var
    $fetch_skills_query = "SELECT s.skill_name
                        FROM skills s
                        JOIN handyman_skills hs ON s.skill_id = hs.skill_id
                        JOIN handyman_profiles hp ON hp.profile_id = hs.profile_id
                        WHERE hp.profile_id =" . $profile_data['profile_id'];
    $fetch_skills_result = mysqli_query($connection, $fetch_skills_query);
    $skills = mysqli_fetch_all($fetch_skills_result);
    $skills = array_column($skills, 0);
    $skills = implode(', ', $skills);

    // get work days and assign the array to a var
    $fetch_days_query = "SELECT day_of_week FROM handyman_work_days WHERE profile_id =" . $profile_data['profile_id'];
    $fetch_days_result = mysqli_query($connection, $fetch_days_query);
    $days = mysqli_fetch_all($fetch_days_result);
    $days = array_column($days, 0);
    $day_names = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    foreach ($days as $day) {
        $selected_days[] = $day_names[$day];
    }
    $days = implode(', ', $selected_days);
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
    <!-- GOOGLE FONT(Patrick Hand SC) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Patrick+Hand+SC&display=swap" rel="stylesheet">
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="partials/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="partials/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="partials/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    <main>
        <div class="form-wrapper">
            <section class="form-section">
                <span class="form-title">User ID: <?= $user_id ?></span>
                <div class="form-container view-account">
                    <ul class="user-info">
                        <label>Name:</label>
                        <li><?= $user_data['full_name'] ?></li>

                        <label>Phone No.</label>
                        <li><?= $user_data['phone_number'] ?></li>

                        <label>Email:</label>
                        <li><?= $user_data['email'] ?></li>

                        <label>Created at:</label>
                        <li><?= $user_data['created_at'] ?></li>

                        <label>Updated at:</label>
                        <li><?= $user_data['updated_at'] ?></li>
                    </ul>
                    <a href="<?= ROOT_URL . 'confirm-delete.php?delete=Account&id=' . $user_id . '&item=' . $user_data['full_name'] . '&admin-delete=yes'?>" class="btn red">Delete account</a>

                    <?php if (mysqli_num_rows($fetch_profile_result) > 0): ?>
                        <ul class="profile-info">
                            <img src="<?= '../' . $profile_data['profile_picture_url'] ?>">

                            <label>Profile ID:</label>
                            <li><?= $profile_data['profile_id'] ?></li>

                            <labe>Profile description:</label>
                            <li><?= $profile_data['profile_description'] ?></li>

                            <label>Preferred location:</label>
                            <li><?= $profile_data['work_location'] ?></li>

                            <label>Skills:</label>
                            <li><?= $skills ?></li>

                            <label>Other interested jobs:</label>
                            <li><?= $profile_data['other_job'] ?></li>
                            
                            <label>Work days:</label>
                            <li><?= $days ?></li>
                            
                            
                            <label>Starting time:</label>
                            <li><?= $profile_data['work_start_time'] ?></li>
                            
                            <label>Ending time:</label>
                            <li><?= $profile_data['work_end_time'] ?></li>
                        </ul>
                        <a href="<?= ROOT_URL . 'confirm-delete.php?delete=Profile&id=' . $profile_data['profile_id'] . '&item=' . $user_data['full_name'] . '&admin-delete=yes'?>" class="btn red">Delete profile</a>
                    <?php endif ?>
                </div>
            </section>
        </div>
    </main>
</body>

</html>