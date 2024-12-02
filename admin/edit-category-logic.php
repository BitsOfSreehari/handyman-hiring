<?php
require 'config/database.php';

// get form data
if (isset($_POST['submit'])) {
    $old_skill_name = filter_var($_SESSION['skill-name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    unset($_SESSION['skill-name']);
    $skill_id = (int) filter_var($_SESSION['skill-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    unset($_SESSION['skill-id']);
    $skill_name = filter_var($_POST['category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // check for change
    if ($old_skill_name != $skill_name) {
        // validate
        if (!$skill_name) {
            $_SESSION['category'] = "Category name is empty.";
        } elseif(strlen($skill_name) > 75) {
            $_SESSION['category'] = "Category name must be under 75 characters.";
        }
        // check duplicate skill name
        $category_check_query = "SELECT * FROM skills WHERE skill_name='$skill_name'";
        $category_check_result = mysqli_query($connection, $category_check_query);
        if (mysqli_num_rows($category_check_result) > 0) {
            $_SESSION['category'] = 'Category name already exists.';
        }

        // reload on error
        if (isset($_SESSION['category'])) {
            header('location: ' . ROOT_URL . 'admin/edit-category.php?skill-id=' . $skill_id . '&item=' . $old_skill_name);
            die();
        } else {
            // Update category name
            $update_query = "UPDATE skills SET skill_name = '$skill_name' WHERE skill_id = $skill_id";
            $update_query_result = mysqli_query($connection, $update_query);
            if (mysqli_errno($connection)) {
                $_SESSION['category'] = "Error updating category";
                header('location: ' . ROOT_URL . 'admin/edit-category.php?skill-id=' . $skill_id . '&item=' . $skill_name);
                die();
            } else {
                $_SESSION['update-category-success'] = "Successfully renamed: $old_skill_name - to - $skill_name";
                header('location: ' . ROOT_URL . 'admin/edit-category.php?skill-id=' . $skill_id . '&item=' . $skill_name);
                die();
            }
        }
    } else {
        $_SESSION['category'] = "No change made.";
        header('location: ' . ROOT_URL . 'admin/edit-category.php?skill-id=' . $skill_id . '&item=' . $skill_name);
        die();
    }
}