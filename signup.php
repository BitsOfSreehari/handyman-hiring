<?php
require 'config/database.php';

// get entered data back on error
$full_name = $_SESSION['signup-data']['full_name'] ?? null;
$phone_number = $_SESSION['signup-data']['phone_number'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$create_password = $_SESSION['signup-data']['create_password'] ?? null;
$confirm_password = $_SESSION['signup-data']['confirm_password'] ?? null;
unset($_SESSION['signup-data']);
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
        <?php if(isset($_SESSION['signup'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['signup'];
                    unset($_SESSION['signup']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <div class="form-wrapper">
            <section class="form-section">
                <h2 class="form-title">Register</h2>
                <div class="form-container sign-form-container">
                    <form action="<?= ROOT_URL ?>signup-logic.php" method="POST">
                        <div class="form-group">
                            <label for="full_name">Name: </label>
                            <input type="text" maxlength="50" value="<?= $full_name ?>" name="full_name" id="full_name">
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone No. </label>
                            <input type="tel" maxlength="10" minlength="10" value="<?= $phone_number ?>" name="phone_number" id="phone_number">
                        </div>

                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="email" value="<?= $email ?>" name="email" id="email">
                        </div>

                        <div class="form-group">
                            <label for="create_password">Password: </label>
                            <input type="password" maxlength="20" value="<?= $create_password ?>" name="create_password" id="create_password">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password: </label>
                            <input type="password" maxlength="20" name="confirm_password" id="confirm_password">
                        </div>
                        
                        <div class="form-control">
                            <button type="submit" class="btn form-btn" name="submit">Signup</button>
                            <span>Already have an account? <a href="signin.php">Signin</a></span>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>