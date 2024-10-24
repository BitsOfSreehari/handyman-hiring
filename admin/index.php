<?php
include 'partials/header.php';
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
        <div class="dash_right">
            <div class="personal-info">
                <img class="avatar" src="../avt.jpg">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Name: </label>
                        <input type="text" name="" id="" value="John Doe">
                    </div>

                    <div class="form-group">
                        <label for="">Phone No. </label>
                        <input type="text" name="" id="" value="9547463377">
                    </div>

                    <div class="form-group">
                        <label for="">Email: </label>
                        <input type="text" name="" id="" value="johndoe@gmail.com">
                    </div>

                    <div class="form-group">
                        <label for="">Password: </label>
                        <input type="password" name="" id="" value="">
                    </div>

                    <div class="form-group">
                        <label for="">Change password: </label>
                        <input type="password" name="" id="" value="">
                    </div>

                    <button type="submit" class="btn" name="submit">Save</button>
                </form>

                <form class="account-delete" method="POST" onsubmit="return confirm('Are you sure you want to delete your ACCOUNT?');">
                    <input type="hidden" name="" value="">
                    <button type="submit" name="submit">Delete Account</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>

</html>