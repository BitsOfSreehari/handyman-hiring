<?php
require 'config/database.php';

// get delete type and item and set session
$delete_type = $_GET['delete'];
$_SESSION['delete-type'] = $delete_type;
$delete_item_id = $_GET['id'];
$_SESSION['delete-item-id'] = $delete_item_id;
$delete_item_name = $_GET['item'];
$_SESSION['delete-item-name'] = $delete_item_name;
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
        <div class="delete-container">
            <?php if ($delete_type == 'account'): ?>
                <h4>Are you sure you want to delete your <?= $delete_type ?>?</h4>
            <?php else: ?>
                <h4>Are you sure you want to delete the <?= $delete_type, ' - ', $delete_item_name ?>?</h4>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>confirm-delete-logic.php" method="POST">
                <button type="submit" class="btn red" name="confirm">Confirm</button>
                <button type="submit" class="btn" name="cancel">Cancel</button>
            </form>
        </div>
        </main>
</body>
</html>