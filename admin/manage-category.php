<?php
include 'partials/header.php';

// redirect to personal info if user is not an admin
if ($_SESSION['user-is-admin'] != 1) {
    header('location: ' . ROOT_URL . 'admin/');
}

// // get entered data back on error
$skill_name = $_SESSION['add-category-data']['skill_name'] ?? null;
unset($_SESSION['add-category-data']);
?>


<div class="dashboard_container">
    <div class="dash_left">
        <ul>
            <li><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
            <?php if ($_SESSION['user-is-handyman'] == 1) : ?>
                <li><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
            <?php endif ?>
            <li><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
            <li class="selected"><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
        </ul>
    </div>

    <main>
    <?php if (isset($_SESSION['add-category-success'])) : ?>
            <div class="alert-message alert-message--green">
                <span>
                    <?= $_SESSION['add-category-success'];
                    unset($_SESSION['add-category-success']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['add-category'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        <div class="dash_right manage-category">
            <form action="<?= ROOT_URL ?>admin/manage-category-logic.php" method="POST">
                <div class="form-group">
                    <label for="">Add category:</label>
                    <input type="text" value="<?= $skill_name ?>" name="skill_name" id="skill_name">
                </div>
                <button type="submit" class="btn" name="submit">Add</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Plumbing</td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                        <td><a href="#" class="btn red">Delete</a></td>
                    </tr>

                    <tr>
                        <td>Plumbing</td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                        <td><a href="#" class="btn red">Delete</a></td>
                    </tr>

                    <tr>
                        <td>Plumbing</td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                        <td><a href="#" class="btn red">Delete</a></td>
                    </tr>

                    <tr>
                        <td>Plumbing</td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                        <td><a href="#" class="btn red">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>

</html>