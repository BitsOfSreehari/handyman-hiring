<?php
include 'partials/header.php';

// get user info from database
$user_id = (int) filter_var($_SESSION['user-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user_info_query = "SELECT full_name, phone_number, email FROM users WHERE user_id = $user_id";
$user_info_result = mysqli_query($connection, $user_info_query);
$user_info_result = mysqli_fetch_assoc($user_info_result);

// set session for unchanged data
$_SESSION['full_name'] = $user_info_result['full_name'];
$_SESSION['phone_number'] = $user_info_result['phone_number'];
$_SESSION['email'] = $user_info_result['email'];
?>


<div class="dashboard_container">
    <div class="dash_left">
        <ul>
            <li class="selected"><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
            <?php if ($_SESSION['user-is-handyman'] == 1) : ?>
                <li><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
            <?php endif ?>
            <?php if ($_SESSION['user-is-admin'] == 1) : ?>
                <li><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
                <li><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
            <?php endif ?>
        </ul>
    </div>
    
    <main>
        <?php if (isset($_SESSION['index-success'])) : ?>
            <div class="alert-message alert-message--green">
                <span>
                    <?php
                    echo $_SESSION['index-success'];
                    unset($_SESSION['index-success']);
                    ?>
                </span>
            </div>
        <?php elseif (isset($_SESSION['index'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['index'];
                    unset($_SESSION['index']);
                    ?>
                </span>
            </div>
        <?php endif ?>

        <div class="dash_right">
            <div class="personal-info">
                <form action="<?= ROOT_URL ?>admin/index-logic.php" method="POST">
                    <div class="form-group">
                        <label for="full_name">Name: </label>
                        <input type="text" name="full_name" id="full_name" placeholder="update user name" value="<?= $user_info_result['full_name'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone No. </label>
                        <input type="text" maxlength="10" name="phone_number" id="phone_number" placeholder="update linked phone No." value="<?= $user_info_result['phone_number'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="text" name="email" id="email" placeholder="update linked email address" value="<?= $user_info_result['email'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" maxlength="20" name="password" id="password" placeholder="confirm your password for saving">
                    </div>

                    <div class="form-group">
                        <label for="new_password">Change password: </label>
                        <input type="password" maxlength="20" name="new_password" id="new_password" placeholder="set new password if you wish to">
                    </div>

                    <a href="<?= ROOT_URL . 'confirm-delete.php?delete=Account&id=' . $user_id . '&item=' . $user_info_result['full_name']?>" class="btn red">Delete Account</a>

                    <button type="submit" class="btn" name="submit">Save</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>

</html>