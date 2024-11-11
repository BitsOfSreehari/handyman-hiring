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

// redirect to index if user is already a handyman
if ($_SESSION['user-is-handyman'] == 1) {
    header('location: ' . ROOT_URL);
}

// get entered data back on error
$selected_skills = $_SESSION['join-data']['skills'] ?? [];
$selected_work_days = $_SESSION['join-data']['work_days'] ?? ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; // make all workdays checked by default
$work_start_time = $_SESSION['join-data']['work_start_time'] ?? '06:00';
$work_end_time = $_SESSION['join-data']['work_end_time'] ?? '18:00';
$work_location = $_SESSION['join-data']['work_location'] ?? null;
$profile_description = $_SESSION['join-data']['profile_description'] ?? null;
unset($_SESSION['join-data']);

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
    <main>
        <?php if(isset($_SESSION['join'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['join'];
                    unset($_SESSION['join']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <div class="form-wrapper">
            <section class="form-section">
                <span class="form-title">Join as Handyman</span>
                <div class="form-container join-handyman-form-container">
                    <form action="<?= ROOT_URL ?>join-as-handyman-logic.php" method="POST" enctype="multipart/form-data">
                        <h2>Profile picture:</h2>
                        <div class="select-avatar">
                            <input type="file" accept=".jpeg,.jpg,.png" name="avatar" id="avatar">
                        </div>

                        <h2>Add skills:</h2>
                        <div class="select-category">
                            <?php 
                            // fetch skills from handyman table
                            $query = "SELECT * FROM skills ORDER BY skill_name";
                            $skills = mysqli_query($connection, $query);
                            if (mysqli_num_rows($skills) > 0) {
                                while ($skill = mysqli_fetch_assoc($skills)) {
                                    // check if this skill is in the selected_skills array
                                    $is_checked = in_array($skill['skill_id'], $selected_skills) ? 'checked' : '';
                                    echo '
                                        <input type="checkbox" id="skill_' . $skill['skill_id'] . '" name="skills[]" value="' . $skill['skill_id'] . '" ' . $is_checked . '>
                                        <label for="skill_' . $skill['skill_id'] . '">' . $skill['skill_name'] . '</label>';
                                }
                            } else {
                                echo '
                                    <div class="alert-message--red">
                                        <span>No Skills defined! Please notify an admin.</span>
                                    </div>';
                            }
                            ?>

                            <div class="form-group">
                                <input type="text" name="other_job" id="other-job" placeholder="Other interested jobs:">
                            </div>
                        </div>

                        <h2>Manage work schedule:</h2>
                        <div class="select-work-schedule">
                            <?php
                            // day check boxes
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            foreach ($days as $day) {
                                // check if the day is in the selected_work_days array
                                $is_checked = in_array($day, $selected_work_days) ? 'checked' : '';
                                echo '
                                    <div class="select-work-schedule-day">
                                        <input type="checkbox" name="work_days[]" id="'. $day . '" value="'. $day . '" ' . $is_checked . '>
                                        <label for="'. $day . '">'. $day . '</label>
                                    </div>';
                            }
                            ?>

                            <div>
                                <label for="work_start_time">From: </label>
                                <input type="time" name="work_start_time" id="work_start_time"  value="<?= $work_start_time ?>">
                                <span>-</span>
                                <label for="work_end_time">To: </label>
                                <input type="time" name="work_end_time" id="work_end_time" value="<?= $work_end_time ?>">
                            </div>
                        </div>

                        <h2>Location/Landmark:</h2>
                        <div class="select-location">
                            <div class="form-group">
                                <input type="text" value="<?= $work_location ?>" name="work_location" id="work-location" placeholder="Preferred work location">
                            </div>
                        </div>

                        <h2>About you:</h2>
                        <div class="about-me">
                            <div class="form-group">
                                <textarea name="profile_description" id="profile-description" maxlength="80" placeholder="Describe your handyman skills or specialties. (max 80 characters)"><?= $profile_description ? $profile_description : ''?></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn form-btn" name="submit">Submit</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>