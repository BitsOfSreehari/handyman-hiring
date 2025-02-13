<!-- use get and clean up login -->
<!-- fallback for java submit -->

<?php
require 'config/database.php';
$fetch_skills_query = "SELECT s.skill_name
                       FROM skills s
                       JOIN handyman_skills hs ON s.skill_id = hs.skill_id
                       JOIN handyman_profiles hp ON hp.profile_id = hs.profile_id
                       WHERE hp.profile_id = 3";
$fetch_skills_result = mysqli_query($connection, $fetch_skills_query);
$skills = mysqli_fetch_all($fetch_skills_result);
var_dump($skills);
$skills = array_column($skills, 0);
$skills = implode(', ', $skills);
var_dump($skills);
?>

view user error after dlt