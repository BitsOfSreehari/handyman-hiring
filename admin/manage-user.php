<?php
include 'partials/header.php';

// redirect to personal info if user is not an admin
if ($_SESSION['user-is-admin'] != 1) {
    header('location: ' . ROOT_URL . 'admin/');
}

// get users from db
$fetch_users_query = "SELECT user_id, full_name, is_handyman, is_admin FROM users ORDER BY full_name";
$fetch_users_result = mysqli_query($connection, $fetch_users_query);
?>


<div class="dashboard_container">
    <div class="dash_left">
        <ul>
            <li><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
            <?php if ($_SESSION['user-is-handyman'] == 1) : ?>
                <li><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
            <?php endif ?>
            <li class="selected"><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
            <li><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
        </ul>
    </div>

    <main>
        <?php if (isset($_SESSION['delete'])) : ?>
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

        <div class="dash_right">
            <?php if (mysqli_num_rows($fetch_users_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Handyman</th>
                            <th>Admin</th>
                            <th>View</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($fetch_users_result)): ?>
                            <tr>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['is_handyman'] = ($user['is_handyman'] == 1) ? 'YES' : 'NO'; ?></td>
                                <td><?= $user['is_admin'] = ($user['is_admin'] == 1) ? 'YES' : 'NO'; ?></td>
                                <td><a href="<?= ROOT_URL . 'admin/view-user.php?user-id=' . $user['user_id'] ?>" class="btn">View</a></td>
                                <td><a href="<?= ROOT_URL . 'confirm-delete.php?delete=Account&id=' . $user['user_id'] . '&item=' . $user['full_name'] . '&admin-delete=yes'?>" class="btn red">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else: ?>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="alert-message--red">
                                        <span>Users - table is empty.</span>
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