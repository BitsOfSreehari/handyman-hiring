<?php
include 'partials/header.php';

// redirect to personal info if user is not an admin
if ($_SESSION['user-is-admin'] != 1) {
    header('location: ' . ROOT_URL . 'admin/');
}

// get skills
$category_query = "SELECT * FROM skills";
$category_query_result = mysqli_query($connection, $category_query);

// get entered data back on error
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
                    <?php
                    echo $_SESSION['add-category-success'];
                    unset($_SESSION['add-category-success']);
                    ?>
                </span>
            </div>
        <?php elseif (isset($_SESSION['category'])) : ?> 
            <div class="alert-message alert-message--red">
                <span>
                    <?= $_SESSION['category'];
                    unset($_SESSION['category']);
                    ?>
                </span>
            </div>
        <?php elseif (isset($_SESSION['delete'])) : ?>
            <div class="alert-message alert-message--red">
                <span>
                    <?php
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                    ?>
                </span>
            </div>
        <?php elseif (isset($_SESSION['delete-success'])) : ?>
            <div class="alert-message alert-message--green">
                <span>
                    <?php
                    echo $_SESSION['delete-success'];
                    unset($_SESSION['delete-success']);
                    ?>
                </span>
            </div>
        <?php endif ?>
        
        <div class="dash_right manage-category">
            <form action="<?= ROOT_URL ?>admin/manage-category-logic.php" method="POST">
                <div class="form-group">
                    <label for="">Add category:</label>
                    <input type="text" maxlength="75" value="<?= $skill_name ?>" name="skill_name" id="skill_name">
                </div>
                <button type="submit" class="btn" name="submit">Add</button>
            </form>

            <?php if (mysqli_num_rows($category_query_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($category = mysqli_fetch_assoc($category_query_result)) {
                                echo '<tr>
                                        <td>' . $category['skill_name'] . '</td>
                                        <td><a href="' . ROOT_URL . 'admin/edit-category.php?skill-id=' . $category['skill_id'] . '&item=' . $category['skill_name'] . '" class="btn">Edit</a></td>
                                        <td><a href="' . ROOT_URL . 'confirm-delete.php?delete=Category&id=' . $category['skill_id'] . '&item=' . $category['skill_name'] . '&admin-delete=yes' . '" class="btn red">Delete</a></td>
                                    </tr>';
                            }
                        ?>
                    </tbody>
                </table>
            <?php else: ?>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="alert-message--red">
                                    <span>Skills - table is empty.</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </main>
</div>
</body>

</html>