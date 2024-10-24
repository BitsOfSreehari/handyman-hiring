<?php
require 'config/database.php';

// get form data if submit button is clicked
if (isset($_POST['submit'])) {
    $skill_name = filter_var($_POST['skill_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate inputs
    if (!$skill_name) {
        $_SESSION['add-category'] = "Category name is empty";
    }
    // check duplicate skill name
    $category_check_query = "SELECT * FROM skills WHERE skill_name='$skill_name'";
    $category_check_result = mysqli_query($connection, $category_check_query);
    if (mysqli_num_rows($category_check_result) > 0) {
        $_SESSION['add-category'] = 'Category is already added';
    }

    // reload on error
    if (isset($_SESSION['add-category'])) {
        // pass entered data back to form
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/manage-category.php');
        die();
    } else {
        // insert category into db
        $insert_query = "INSERT INTO skills (skill_name) VALUES ('$skill_name')";
        $insert_query_result = mysqli_query($connection, $insert_query);
        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Error adding category";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "$skill_name added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        }
    }
}