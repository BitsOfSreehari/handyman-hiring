<?php
require 'partials/header.php';
?>


    <div class="dashboard_container">
        <div class="dash_left">
            <ul>
                <li><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
                <li><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
                <li><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
                <li class="selected"><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
            </ul>
        </div>

        <main>
            <div class="dash_right manage-category">
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Add category:</label>
                        <input type="text" name="" id="">
                    </div>
                    <button type="submit" class="btn" name="submit">Submit</button>
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
                            <td><a href="#" class="btn danger">Delete</a></td>
                        </tr>

                        <tr>
                            <td>Plumbing</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn danger">Delete</a></td>
                        </tr>

                        <tr>
                            <td>Plumbing</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn danger">Delete</a></td>
                        </tr>

                        <tr>
                            <td>Plumbing</td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php" class="btn">Edit</a></td>
                            <td><a href="#" class="btn danger">Delete</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>