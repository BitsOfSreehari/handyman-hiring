<?php
include 'partials/header.php';

// get selected_skill and make it persistent
if (isset($_GET['skill_id'])) {
    $_SESSION['selected_skill_id'] = (int) $_GET['skill_id'];
}

// get categories (skills) from db
$fetch_skills_query = "SELECT skill_id, skill_name FROM skills";
$fetch_skills_result = mysqli_query($connection, $fetch_skills_query);

// set selected skill id to first skill on first load
if (isset($_SESSION['selected_skill_id'])) {
    $selected_skill_id = $_SESSION['selected_skill_id'];
} elseif (mysqli_num_rows($fetch_skills_result) > 0) {
    $row = mysqli_fetch_assoc($fetch_skills_result);
    $selected_skill_id = (int) $row['skill_id'];
    mysqli_data_seek($fetch_skills_result, 0);
}

// get profiles from db
if (mysqli_num_rows($fetch_skills_result) > 0 && !isset($_GET['search'])) {
    $fetch_profiles_query = "
        SELECT
            p.profile_id,
            p.profile_picture_url,
            u.full_name,
            p.work_location,
            p.other_job,
            p.work_start_time,
            p.work_end_time,
            GROUP_CONCAT(
                DISTINCT CASE
                    WHEN hwd.day_of_week = 0 THEN 'Mon'
                    WHEN hwd.day_of_week = 1 THEN 'Tue'
                    WHEN hwd.day_of_week = 2 THEN 'Wed'
                    WHEN hwd.day_of_week = 3 THEN 'Thu'
                    WHEN hwd.day_of_week = 4 THEN 'Fri'
                    WHEN hwd.day_of_week = 5 THEN 'Sat'
                    WHEN hwd.day_of_week = 6 THEN 'Sun'
                END
                ORDER BY hwd.day_of_week ASC
                SEPARATOR ' | '
            ) AS work_days,
            AVG(hr.rating) AS average_rating
        FROM
            handyman_profiles p
        JOIN
            users u ON p.user_id = u.user_id
        JOIN
            handyman_skills hs ON p.profile_id = hs.profile_id
        JOIN
            skills s ON hs.skill_id = s.skill_id
        JOIN
            handyman_work_days hwd ON p.profile_id = hwd.profile_id
        LEFT JOIN
            handyman_rating hr ON p.profile_id = hr.profile_id
        WHERE
            s.skill_id = $selected_skill_id
        GROUP BY
            p.profile_id
            ORDER BY u.full_name ASC
    ";
    $fetch_profiles_result = mysqli_query($connection, $fetch_profiles_query);
}

// get search term and show profiles in association
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_query = "
        SELECT
            p.profile_id,
            p.profile_picture_url,
            u.full_name,
            p.work_location,
            p.other_job,
            p.work_start_time,
            p.work_end_time,
            GROUP_CONCAT(
                DISTINCT CASE
                    WHEN hwd.day_of_week = 0 THEN 'Mon'
                    WHEN hwd.day_of_week = 1 THEN 'Tue'
                    WHEN hwd.day_of_week = 2 THEN 'Wed'
                    WHEN hwd.day_of_week = 3 THEN 'Thu'
                    WHEN hwd.day_of_week = 4 THEN 'Fri'
                    WHEN hwd.day_of_week = 5 THEN 'Sat'
                    WHEN hwd.day_of_week = 6 THEN 'Sun'
                END
                ORDER BY hwd.day_of_week ASC
                SEPARATOR ' | '
            ) AS work_days,
            AVG(hr.rating) AS average_rating
        FROM
            handyman_profiles p
        JOIN
            users u ON p.user_id = u.user_id
        JOIN
            handyman_skills hs ON p.profile_id = hs.profile_id
        JOIN
            skills s ON hs.skill_id = s.skill_id
        JOIN
            handyman_work_days hwd ON p.profile_id = hwd.profile_id
        LEFT JOIN
            handyman_rating hr ON p.profile_id = hr.profile_id
        WHERE
            p.other_job LIKE '%$search_term%' OR s.skill_name LIKE '%$search_term%'
        GROUP BY
            p.profile_id
            ORDER BY u.full_name ASC
    ";
    $fetch_profiles_result = mysqli_query($connection, $search_query);
}
?>


<main>
    <section class="category-section">
        <span>What job do you need a hand with..?</span>
        <div class="category-container">
            <ul>
                <?php if (mysqli_num_rows($fetch_skills_result) > 0): ?>
                    <?php while ($skill_row = mysqli_fetch_assoc($fetch_skills_result)): ?>
                        <li <?= ($selected_skill_id == $skill_row['skill_id']) && !isset($_GET['search']) ? 'class="selected"' : '' ?>>
                            <a href="index.php?skill_id=<?= $skill_row['skill_id'] ?>"><?= $skill_row['skill_name'] ?></a>
                        </li>
                    <?php endwhile ?>
                <?php else: ?>
                    <div class="alert-message--red">
                        <span>No Skills defined! Please notify an admin.</span>
                    </div>
                <?php endif ?>
            </ul>
        </div>

        <span class="search">
            <form action="" method="GET">
                <label for="search">Other Odd Jobs: </label>
                <input type="text" name="search" id="search" placeholder="Search">
            </form>
        </span>
    </section>
    <!-- =============END OF CATOGORIES============= -->
    <section class="profile-section">
        <?php if ($fetch_profiles_result->num_rows > 0): ?>
            <?php while ($row = $fetch_profiles_result->fetch_assoc()): ?>
                <a href="<?= ROOT_URL ?>profile.php?profile_id=<?= $row['profile_id'] ?>">
                    <div class="profile">
                        <span class="name"><?= $row['full_name'] ?></span>
                        <img class="avatar" src="<?= $row['profile_picture_url'] ?>">
                        <div class="profile-headsup">
                            <li><?= $row['work_location'] ?></li>
                            <li><?= $row['work_days'] ?></li>
                            <li><?= date("g:i A", strtotime($row['work_start_time'])) ?> - <?= date("g:i A", strtotime($row['work_end_time'])) ?></li>
                        </div>
                        <div class="rating">
                            <?php if ((float) $row['average_rating'] > 0): ?>
                                <?php
                                $rating = $row['average_rating'];
                                $whole_part = (int) $rating;
                                $decimal_part = $rating - $whole_part;
                                while ($whole_part > 0) {
                                    echo '<svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                          </svg>';
                                    $whole_part--;
                                }
                                if ($decimal_part <= 0.5 && $decimal_part != 0) {
                                    echo '<svg width="13" height="23" viewBox="0 0 13 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.56476 7.42668L8.7801 7.38005L8.891 7.18966L12 1.85189V19.0489L5.73658 21.809L6.4589 14.6749L6.4811 14.4556L6.33429 14.2913L1.55658 8.94428L8.56476 7.42668Z" fill="#FFCC18" stroke="#1E201E"/>
                                          </svg>';
                                } elseif ($decimal_part > 0.5) {
                                    echo '<svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                          </svg>';
                                }
                                ?>
                            <?php endif ?>
                        </div>
                    </div>
                </a>
            <?php endwhile ?>
            <?php else: ?>
                <div class="alert-message--red">
                    <span>No Handyman available for now.</span>
                </div>
            <?php endif ?>
    </section>
    <!-- =============END OF PROFILES============= -->
    <section class="bottom-section">
        <div class="nav-section">
            <a href="<?= ROOT_URL ?>admin" class="btn">Account settings</a>
            <a href="<?= ROOT_URL ?>logout.php" class="btn">Logout</a>
        </div>
        <div class="join-handyman">
            <?php if ($_SESSION['user-is-handyman'] !== 1): ?>
                <p>Interested in a side gig? Handyman.com is perfect for anyone looking to earn extra income—students, professionals, or anyone with spare time. Join our network today to offer your services or request assistance, and experience the perfect blend of convenience and opportunity!</p>
                <a href="<?= ROOT_URL ?>join-as-handyman.php" class="btn">Join as Handyman</a>
            <?php else: ?>
                <p>It's important to keep your profile up to date, for potential customers. An updated profile helps building trust and credibility. Stay current to ensure your profile reflects the best version of yourself, and attract more opportunities!</p>
                <a href="<?= ROOT_URL ?>admin/professional-info.php" class="btn">Review profile</a>
            <?php endif ?>
        </div>
    </section>
</main>


<?php
include 'partials/footer.php';
?>