<?php
require 'config/database.php';
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
        <div class="form-wrapper">
            <section class="form-section">
                <span class="form-title">Edit Category</span>
                <div class="form-container join-handyman-form-container professional-info">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Category title: </label>
                            <input type="text" name="" id="" value="Plumbing">
                        </div>

                        <button type="submit" class="btn" name="submit">Save</button>
                        <a href="#" class="btn red">Delete</a>

                        <div class="handyman-list">
                            <h2>Handyman list:</h2>
                            <ul>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                                <li>John Doe</li>
                            </ul>
                        </div>
                        
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>