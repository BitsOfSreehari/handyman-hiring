<?php
include 'partials/header.php';

// redirect if profile_id is not set
if (!isset($_GET['profile_id'])) {
    header('location: ' . ROOT_URL);
}

// get profile_id and set session
$_SESSION['profile-id'] = $_GET['profile_id'] ?? $_SESSION['profile-id'];

$user_id = (int) $_SESSION['user-id'];
$profile_id = (int) $_SESSION['profile-id'];

// get profile details excluding skills from db
$profile_query = "SELECT
                    p.profile_picture_url,
                    u.full_name,
                    u.phone_number,
                    p.work_location,
                    AVG(hr.rating) AS average_rating,
                    p.profile_description,
                    p.other_job,
                    p.work_start_time,
                    p.work_end_time
                  FROM
                    handyman_profiles p
                  JOIN
                    users u ON p.user_id = u.user_id
                  LEFT JOIN
                    handyman_rating hr ON p.profile_id = hr.profile_id
                  WHERE
                    p.profile_id = $profile_id";
$profile_result = mysqli_query($connection, $profile_query);

// get rating from database if exists
$query = "SELECT rating FROM handyman_rating WHERE user_id = $user_id AND profile_id = $profile_id";
$result = mysqli_query($connection, $query);
$user_rating = 0;
if ($row = mysqli_fetch_assoc($result)) {
    $user_rating = $row['rating'];
}
?>


<main>
    <?php if ($profile_result->num_rows > 0): ?>
        <?php while ($row = $profile_result->fetch_assoc()): ?>
            <div class="profile-maximize">
                <div class="profile-left">
                    <img class="avatar" src="<?= $row['profile_picture_url'] ?>">
                    <h2><?= $row['full_name'] ?></h2>
                    <p><?= $row['work_location'] ?></p>
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
                    <p><?= $row['profile_description'] ?></p>
                </div>

                <div class="profile-right">
                    <h2>Skills:</h2>
                    <div class="profile-right-item">
                        <ul class="profile-skills">
                            <?php
                            $fetch_skills_query = "SELECT s.skill_name FROM handyman_skills hs JOIN skills s ON hs.skill_id = s.skill_id WHERE hs.profile_id = $profile_id";
                            $fetch_skills_result = mysqli_query($connection, $fetch_skills_query);
                            if (mysqli_num_rows($fetch_skills_result) > 0) {
                                while ($skill_row = mysqli_fetch_assoc($fetch_skills_result)) {
                                    echo '<li>' . $skill_row['skill_name'] . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <h2>Working days:</h2>
                    <div class="profile-right-item">
                        <ul class="profile-schedule">
                            <?php
                            $fetch_days_query = "SELECT 
                                                    CASE 
                                                        WHEN day_of_week = 0 THEN 'Monday'
                                                        WHEN day_of_week = 1 THEN 'Tuesday'
                                                        WHEN day_of_week = 2 THEN 'Wednesday'
                                                        WHEN day_of_week = 3 THEN 'Thursday'
                                                        WHEN day_of_week = 4 THEN 'Friday'
                                                        WHEN day_of_week = 5 THEN 'Saturday'
                                                        WHEN day_of_week = 6 THEN 'Sunday'
                                                    END AS day
                                                 FROM handyman_work_days
                                                 WHERE profile_id = $profile_id";
                            $fetch_days_result = mysqli_query($connection, $fetch_days_query);
                            if (mysqli_num_rows($fetch_days_result) > 0) {
                                while ($day = mysqli_fetch_assoc($fetch_days_result)) {
                                    echo '<li>' . $day['day'] . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <h2>Working hours:</h2>
                    <div class="profile-right-item">
                        <p><?= date("g:i A", strtotime($row['work_start_time'])) ?> - <?= date("g:i A", strtotime($row['work_end_time'])) ?></p>
                    </div>
                    
                    <a href="https://wa.me/<?= $row['phone_number'] ?>" class="btn contact-btn">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2386_3)">
                            <path d="M23.6785 18.3877C23.6161 18.3577 21.2833 17.209 20.8687 17.0598C20.6995 16.999 20.5182 16.9397 20.3253 16.9397C20.0103 16.9397 19.7457 17.0967 19.5396 17.405C19.3065 17.7514 18.6011 18.576 18.3831 18.8224C18.3546 18.8549 18.3158 18.8937 18.2925 18.8937C18.2716 18.8937 17.9106 18.7451 17.8013 18.6976C15.2987 17.6105 13.3992 14.9964 13.1387 14.5556C13.1015 14.4922 13.1 14.4634 13.0997 14.4634C13.1088 14.4299 13.193 14.3455 13.2364 14.302C13.3635 14.1762 13.5011 14.0105 13.6343 13.8502C13.6974 13.7743 13.7606 13.6982 13.8226 13.6265C14.0158 13.4017 14.1019 13.2271 14.2016 13.025L14.2539 12.9199C14.4974 12.4361 14.2894 12.0278 14.2222 11.8959C14.167 11.7856 13.182 9.40824 13.0772 9.15847C12.8254 8.55577 12.4926 8.27515 12.0302 8.27515C11.9873 8.27515 12.0302 8.27515 11.8502 8.28273C11.6311 8.29198 10.4379 8.44907 9.91027 8.78164C9.35079 9.13437 8.4043 10.2587 8.4043 12.2361C8.4043 14.0157 9.53365 15.696 10.0185 16.3351C10.0306 16.3512 10.0527 16.3839 10.0848 16.4309C11.9418 19.1428 14.2567 21.1526 16.6034 22.09C18.8626 22.9925 19.9324 23.0968 20.5406 23.0968H20.5407C20.7963 23.0968 21.0009 23.0767 21.1813 23.0589L21.2958 23.048C22.0763 22.9788 23.7914 22.0901 24.1815 21.006C24.4889 20.152 24.5699 19.219 24.3654 18.8804C24.2254 18.6502 23.984 18.5344 23.6785 18.3877Z" fill="#25D366"/>
                            <path d="M16.284 0C7.61743 0 0.566625 6.99782 0.566625 15.5993C0.566625 18.3813 1.31114 21.1045 2.72153 23.4879L0.0220018 31.451C-0.0282838 31.5995 0.00911872 31.7636 0.118937 31.8754C0.19821 31.9564 0.305742 32 0.41556 32C0.457638 32 0.500028 31.9937 0.541378 31.9805L8.84475 29.3419C11.117 30.5559 13.6851 31.1968 16.2841 31.1968C24.9499 31.1969 32 24.1998 32 15.5993C32 6.99782 24.9499 0 16.284 0ZM16.284 27.9474C13.8384 27.9474 11.4697 27.2412 9.43353 25.9051C9.36506 25.8602 9.28558 25.8371 9.20558 25.8371C9.1633 25.8371 9.12091 25.8435 9.07966 25.8566L4.92018 27.1788L6.26293 23.2174C6.30636 23.0891 6.28465 22.9477 6.20465 22.8384C4.6541 20.7198 3.83447 18.2166 3.83447 15.5993C3.83447 8.78961 9.4193 3.24945 16.2839 3.24945C23.1477 3.24945 28.7319 8.78961 28.7319 15.5993C28.732 22.4081 23.1479 27.9474 16.284 27.9474Z" fill="#25D366"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_2386_3">
                            <rect width="32" height="32" fill="white"/>
                            </clipPath>
                            </defs>
                        </svg>
                        CONTACT
                    </a>

                    <div class="star-rate-container">
                        <span>Rate this profile:</span>
                        <form action="<?= ROOT_URL ?>profile-logic.php" method="POST">
                            <div class="star-rate">
                                <input type="radio" name="rating" id="star5" value="5" <?php if ($user_rating == 5) echo "checked" ?>>
                                <label for="star5">
                                    <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                    </svg>
                                </label>
                                
                                <input type="radio" name="rating" id="star4" value="4" <?php if ($user_rating == 4) echo "checked" ?>>
                                <label for="star4">
                                    <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                    </svg>
                                </label>
                                
                                <input type="radio" name="rating" id="star3" value="3" <?php if ($user_rating == 3) echo "checked" ?>>
                                <label for="star3">
                                    <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                    </svg>
                                </label>
                                
                                <input type="radio" name="rating" id="star2" value="2" <?php if ($user_rating == 2) echo "checked" ?>>
                                <label for="star2">
                                    <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                    </svg>
                                </label>
                                
                                <input type="radio" name="rating" id="star1" value="1" <?php if ($user_rating == 1) echo "checked" ?>>
                                <label for="star1">
                                    <svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
                                    </svg>
                                </label>

                                <br>
                                <button type="submit" class="btn rating-btn" name="submit"><?php $user_rating > 0 ? print "Update" : print "Submit" ?></button>
                                <br>
                                <label id="star-text">&#8203;</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile ?>
    <?php endif ?>
</main>


<?php
include 'partials/footer.html';
?>