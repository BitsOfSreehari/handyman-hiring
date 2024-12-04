<?php
require 'config/database.php';

// back url for returnining
if (isset($_SERVER['HTTP_REFERER'])) {
    // get the referer URL
    $referer = $_SERVER['HTTP_REFERER'];

    // array of trusted domains or URLs
    $trusted_domains = [
        'localhost'
    ];

    // extract domain from referer
    $parsed_referer = parse_url($referer, PHP_URL_HOST);

    // check if the referer's domain is in the list of trusted domains
    if (in_array($parsed_referer, $trusted_domains)) {
        // redirect to the referer URL if it is from a trusted domain
        $back_url = $referer;
    } else {
        // redirect to a default page if domain is not trusted
        $back_url = ROOT_URL . 'admin';
    }
} else {
    // if there is no referer set
    $back_url = ROOT_URL . 'admin';
}
$_SESSION['back-url'] = $back_url;

// get delete type and item and set session
$delete_type = $_GET['delete'];
$_SESSION['delete-type'] = $delete_type;
$delete_item_id = $_GET['id'];
$_SESSION['delete-item-id'] = $delete_item_id;
$delete_item_name = $_GET['item'];
$_SESSION['delete-item-name'] = $delete_item_name;

// check if admin is deleting
if (isset($_GET['admin-delete'])) {
    $admin_delete = ($_GET['admin-delete'] == 'yes') ? true : false;
}
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
            <?php if (isset($admin_delete) && $admin_delete === true): ?>
                <h4>Are you sure you want to delete the <?= $delete_type . ' - ' . $delete_item_name ?>?</h4>
            <?php elseif ($delete_type == 'Account' || $delete_type == 'Profile'): ?>
                <h4>Are you sure you want to delete your <?= $delete_type ?>?</h4>
            <?php else: ?>
                <h4>Are you sure you want to delete the <?= $delete_type, ' - ', $delete_item_name ?>?</h4>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>confirm-delete-logic.php" method="POST">
                <button type="submit" class="btn red" name="confirm">Confirm</button>
                <a class="btn" href="<?= $back_url ?>" name="cancel">Cancel</a>
            </form>
        </div>
        </main>
</body>
</html>