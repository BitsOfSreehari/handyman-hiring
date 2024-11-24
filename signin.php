<?php
require 'config/database.php';

// login with
$selected_login_with = $_SESSION['selected_login_with'] = isset($_POST['login_with']) ? $_POST['login_with'] : 'ph';

// get entered data back on error
$phone_number = $_SESSION['signin-data']['phone_number'] ?? null;
$email = $_SESSION['signin-data']['email'] ?? null;
unset($_SESSION['signin-data']);
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
        <?php if (isset($_SESSION['signup-success'])) : ?>
            <div class="alert-message alert-message--green">
                <span>
                    <?= $_SESSION['signup-success'];
                    unset($_SESSION['signup-success']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['signin'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['signin'];
                    unset($_SESSION['signin']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <div class="form-wrapper">
            <section class="form-section">
                <h2 class="form-title">Login</h2>
                <div class="form-container sign-form-container">
                    <form action="" method="POST">
                        <div class="login-with">
                            <input type="radio" id="login-using-ph" name="login_with" value="ph" <?= ($selected_login_with === 'ph') ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <label for="login-using-ph">Login using Phone No.</label>

                            <input type="radio" id="login-using-email" name="login_with" value="mail" <?php echo ($selected_login_with === 'mail') ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <label for="login-using-email">Login using Email</label>
                        </div>
                    </form>
                    <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                        <?php
                        switch ($selected_login_with) {
                            case 'ph':
                                echo '
                                    <div class="form-group">
                                        <label for="phone_number">Phone No. </label>
                                        <input type="tel" maxlength="10" minlength="10" value="' . $phone_number . '" name="phone_number" id="phone_number">
                                    </div>';
                                break;
                            case 'mail':
                                echo '
                                    <div class="form-group">
                                        <label for="email">Email: </label>
                                        <input type="email" value="' . $email . '" name="email" id="email">
                                    </div>';
                                break;
                            default:
                                echo '
                                    <div class="form-group">
                                        <label for="phone_number">Phone No. </label>
                                        <input type="tel" maxlength="10" minlength="10" value="' . $phone_numbe . '" name="phone_number" id="phone_number">
                                    </div>';
                                break;
                        }
                        ?>

                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input type="password" maxlength="20" name="password" id="password">
                        </div>

                        <div class="form-control">
                            <button type="submit" class="btn form-btn" name="submit">Signin</button>
                            <span>Don't have an account? <a href="signup.php">Signup</a></span>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>