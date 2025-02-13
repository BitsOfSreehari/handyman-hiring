<?php
include 'partials/header.php';

// redirect to personal info if user is not a handyman
if ($_SESSION['user-is-handyman'] != 1) {
    header('location: ' . ROOT_URL . 'admin/');
}

// get profile id and redirect if not set
if (isset($_SESSION['profile-id'])) {
    $profile_id = (int) $_SESSION['profile-id'];
} else {
    header('location: ' . ROOT_URL . 'admin/');
}


// get data from profiles table
$query = "SELECT profile_picture_url, other_job, work_start_time, work_end_time, work_location, profile_description FROM handyman_profiles WHERE profile_id = $profile_id";
$result = mysqli_query($connection, $query);
$profile_data = mysqli_fetch_assoc($result);
?>


<div class="dashboard_container">
    <div class="dash_left">
        <ul>
            <li><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
            <li class="selected"><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
            <?php if ($_SESSION['user-is-admin'] == 1) : ?>
                <li><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
                <li><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
            <?php endif ?>
        </ul>
    </div>

    <main>
        <?php if (isset($_SESSION['professional-info-success'])) : ?>
            <div class="alert-message alert-message--green">
                <span>
                    <?php
                    echo $_SESSION['professional-info-success'];
                    unset($_SESSION['professional-info-success']);
                    ?>
                </span>
            </div>
        <?php elseif (isset($_SESSION['professional-info'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['professional-info'];
                    unset($_SESSION['professional-info']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        
        <div class="dash_right">
            <div class="professional-info">
                <div class="avatar-container">
                    <label for="avatar">
                        <img class="avatar" src="<?= ROOT_URL . $profile_data['profile_picture_url'] ?>">
                        <svg class="edit-icon" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M54 51.459H6V5.98798H30V0.304086H0V57.1429H60V28.7235H54V51.459ZM18 28.4279L47.517 0L60 11.7571L29.526 40.0912H18V28.4279Z" fill="black"/>
                        </svg>
                    </label>
                </div>
                
                <form action="<?= ROOT_URL . 'admin/professional-info-logic.php' ?>" method="POST" enctype="multipart/form-data">
                    <input type="file" name="avatar" id="avatar" required onchange="this.form.submit()">
                </form>

                <form action="<?= ROOT_URL . 'admin/professional-info-logic.php' ?>" method="POST">
                    <h2>Manage skills:</h2>
                    <div class="select-category">
                        <?php
                        // fetch skills from handyman table
                        $query = "SELECT * FROM skills ORDER BY skill_name";
                        $skills = mysqli_query($connection, $query);
                        // fetch selected skills
                        $query = "SELECT s.skill_id
                                  FROM skills s
                                  JOIN handyman_skills hs ON s.skill_id = hs.skill_id
                                  JOIN handyman_profiles hp ON hp.profile_id = hs.profile_id
                                  WHERE hp.profile_id = $profile_id";
                        $result = mysqli_query($connection, $query);
                        $selected_skills = mysqli_fetch_all($result);
                        $selected_skills = array_column($selected_skills, 0);
                        // print categories
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
                            <input type="text" name="other_job" id="other-job" value="<?= $profile_data['other_job'] ?>" placeholder="Other interested jobs:">
                        </div>
                    </div>

                    <h2>Manage work schedule:</h2>
                    <div class="select-work-schedule">
                        <?php
                        // fetch selected skills
                        $query = "SELECT day_of_week FROM handyman_work_days WHERE profile_id = $profile_id";
                        $result = mysqli_query($connection, $query);
                        $selected_work_days = mysqli_fetch_all($result);
                        $selected_work_days = array_column($selected_work_days, 0);
                        // print days
                        $days = [0, 1, 2, 3, 4, 5, 6];
                        $day_names = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        foreach ($days as $day) {
                        $day_name = $day_names[$day];
                        // check if the day is in the selected_work_days array
                        $is_checked = in_array($day, $selected_work_days) ? 'checked' : '';
                        echo '
                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="work_days[]" id="'. $day_name . '" value="'. $day . '" ' . $is_checked . '>
                                <label for="'. $day_name . '">'. $day_name . '</label>
                            </div>';
                        }
                        ?>
                    </div>
                    <div class="select-work-time">
                        <label for="work_start_time">From: </label>
                        <input type="time" name="work_start_time" id="work_start_time"  value="<?= $profile_data['work_start_time'] ?>">
                        <span>-</span>
                        <label for="work_end_time">To: </label>
                        <input type="time" name="work_end_time" id="work_end_time" value="<?= $profile_data['work_end_time'] ?>">
                    </div>

                    <h2>Locality/Landmark:</h2>
                    <div class="select-location">
                        <div class="form-group">
                            <input type="text" name="work_location" id="work_location" placeholder="Preferred work locality" value="<?= $profile_data['work_location'] ?>">
                        </div>
                    </div>

                    <h2>About you:</h2>
                    <div class="about-me">
                        <div class="form-group">
                            <textarea name="profile_description" id="profile_description" maxlength="80" placeholder="Describe your handyman skills or specialties.
                            (Under 80 characters)"><?= $profile_data['profile_description'] ?></textarea>
                        </div>
                    </div>

                    <a href="<?= ROOT_URL . 'confirm-delete.php?delete=Profile&id=' . $profile_id . '&item='?>" class="btn red">Delete Profile</a>
                    
                    <button type="submit" class="btn" name="submit">Save</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>

</html>