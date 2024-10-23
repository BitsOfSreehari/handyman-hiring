<?php
include 'partials/header.php';
?>


    <div class="dashboard_container">
        <div class="dash_left">
            <ul>
                <li><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
                <li><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
                <li class="selected"><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
                <li><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
            </ul>
        </div>

        <main>
            <div class="dash_right">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Handyman</th>
                            <th>Admin</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>YES</td>
                            <td>NO</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-user.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn red">Delete</a></td>
                        </tr>

                        <tr>
                            <td>John Doe</td>
                            <td>YES</td>
                            <td>NO</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-user.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn red">Delete</a></td>
                        </tr>

                        <tr>
                            <td>John Doe</td>
                            <td>YES</td>
                            <td>NO</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-user.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn red">Delete</a></td>
                        </tr>

                        <tr>
                            <td>John Doe</td>
                            <td>YES</td>
                            <td>NO</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-user.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn red">Delete</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>