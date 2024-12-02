<?php
require 'config/database.php';

// redirect to personal info if user is not an admin
if ($_SESSION['user-is-admin'] != 1) {
    header('location: ' . ROOT_URL . 'admin/');
}

// get skill id and set session
if (isset($_GET['skill-id'])) {
    $skill_id = $_GET['skill-id'];
    $_SESSION['skill-id'] = $skill_id;
    $skill_name = $_GET['item'];
    $_SESSION['skill-name'] = $skill_name;
} else {
    header('location: ' . ROOT_URL . 'admin/');
}

// get profiles with this skill from db
$skill_query = "
    SELECT
        u.full_name
    FROM
        users u
    JOIN
        handyman_profiles hp ON u.user_id = hp.user_id
    JOIN
        handyman_skills hs ON hp.profile_id = hs.profile_id
    WHERE
        hs.skill_id = $skill_id";
$skills_result = mysqli_query($connection, $skill_query);
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
        <?php if (isset($_SESSION['category'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['category'];
                    unset($_SESSION['category']);
                    ?>
                </span>
            </div>
        <?php elseif (isset($_SESSION['update-category-success'])) : ?>
            <div class="alert-message alert-message--green">
                <span>
                    <?php
                    echo $_SESSION['update-category-success'];
                    unset($_SESSION['update-category-success']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <div class="form-wrapper">
            <section class="form-section">
                <span class="form-title">Edit Category</span>
                <div class="form-container join-handyman-form-container professional-info">
                    <form action="edit-category-logic.php" method="POST">
                        <div class="form-group">
                            <label for="category">Category title: </label>
                            <input type="text" name="category" id="category" value="<?= $skill_name ?>">
                        </div>

                        <button type="submit" class="btn" name="submit">Save</button>
                        <a href="<?= ROOT_URL . 'confirm-delete.php?delete=Category&id=' . $skill_id . '&item=' . $skill_name ?>" class="btn red">Delete</a>

                        <div class="handyman-list">
                            <h2>Handyman list:</h2>
                            <?php
                            if (mysqli_num_rows($skills_result) > 0) {
                                while ($name = mysqli_fetch_assoc($skills_result)) {
                                    echo '<ul>
                                            <li>' . $name['full_name'] . '</li>
                                        </ul>';
                                }
                            } else {
                                echo '<div class="alert-message--red">
                                        <span>No profiles are associated with this category.</span>
                                    </div>';
                            }
                            ?>
                        </div>
                        
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>