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
                <span class="form-title">Edit User details</span>
                <div class="form-container join-handyman-form-container professional-info">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Name: </label>
                            <input type="text" name="" id="" value="John Doe">
                        </div>

                        <div class="form-group">
                            <label for="">Phone No. </label>
                            <input type="text" name="" id="" value="9547463377">
                        </div>

                        <div class="form-group">
                            <label for="">Email: </label>
                            <input type="text" name="" id="" value="johndoe@gmail.com">
                        </div>

                        <div class="user-role">
                            <input type="checkbox" name="" id="is_handyman" value="" checked>
                            <label for="is_handyman">Handyman</label>
                            
                            <input type="checkbox" name="" id="is_admin" value="">
                            <label for="is_admin">Admin</label>
                        </div>

                        <h2>Skills:</h2>
                        <div class="select-category">
                            <input type="checkbox" id="plumbing" name="" value="">
                            <label for="plumbing">Plumbing</label>

                            <input type="checkbox" id="electrical" name="" value="">
                            <label for="electrical">Electrical</label>

                            <input type="checkbox" id="painting" name="" value="">
                            <label for="painting">Painting</label>

                            <input type="checkbox" id="home-cleaning" name="" value="">
                            <label for="home-cleaning">Home cleaning</label>

                            <input type="checkbox" id="carpentry" name="" value="">
                            <label for="carpentry">Carpentry</label>

                            <input type="checkbox" id="roofing" name="" value="">
                            <label for="roofing">Roofing</label>

                            <input type="checkbox" id="flooring" name="" value="">
                            <label for="flooring">Flooring</label>

                            <input type="checkbox" id="landscaping" name="" value="">
                            <label for="landscaping">Landscaping</label>
                            
                            <div class="form-group">
                                <input type="text" name="" id="" placeholder="Other interested jobs:">
                            </div>
                        </div>

                        <h2>Work schedule:</h2>
                        <div class="select-work-schedule">
                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="mon" value="" checked>
                                <label for="mon">Monday</label>
                            </div>

                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="tue" value="" checked>
                                <label for="tue">Tuesday</label>
                            </div>

                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="wed" value="" checked>
                                <label for="wed">Wednesday</label>
                            </div>

                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="thu" value="" checked>
                                <label for="thu">Thursday</label>
                            </div>

                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="fri" value="" checked>
                                <label for="fri">Friday</label>
                            </div>

                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="sat" value="" checked>
                                <label for="sat">Saturday</label>
                            </div>

                            <div class="select-work-schedule-day">
                                <input type="checkbox" name="" id="sun" value="" checked>
                                <label for="sun">Sunday</label>
                            </div>

                            <div>
                                <label for="">From: </label>
                                <input type="time" name="" id=""  value="06:00">
                                <span>-</span>
                                <label for="">To: </label>
                                <input type="time" name="" id="" value="18:00">
                            </div>
                        </div>

                        <h2>Location/Landmark:</h2>
                        <div class="select-location">
                            <div class="form-group">
                                <input type="text" name="" id="" placeholder="Preferred work location">
                            </div>
                        </div>

                        <h2>About:</h2>
                        <div class="about-me">
                            <div class="form-group">
                                <textarea name="" id="" maxlength="80" placeholder="Describe your handyman skills or specialties. (max 80 characters)"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn" name="submit">Save</button>
                        <a href="#" class="btn danger">Delete</a>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>