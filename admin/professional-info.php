<?php
require 'partials/header.php';
?>


    <div class="dashboard_container">
        <div class="dash_left">
            <ul>
                <li><a href="<?= ROOT_URL ?>admin/index.php">Personal Info</a></li>
                <li class="selected"><a href="<?= ROOT_URL ?>admin/professional-info.php">Professional Info</a></li>
                <li><a href="<?= ROOT_URL ?>admin/manage-user.php">Manage Users</a></li>
                <li><a href="<?= ROOT_URL ?>admin/manage-category.php">Manage Categories</a></li>
            </ul>
        </div>

        <main>
            <div class="dash_right">
                <div class="professional-info">
                    <form action="" method="POST">
                        <h2>Manage skills:</h2>
                        <div class="select-category">
                            <input type="checkbox" id="plumbing" name="" value="" checked>
                            <label for="plumbing">Plumbing</label>

                            <input type="checkbox" id="electrical" name="" value="">
                            <label for="electrical">Electrical</label>

                            <input type="checkbox" id="painting" name="" value="" checked>
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
                                <input type="text" name="" id="" placeholder="Other interested jobs:" value="Care taking, Cooking">
                            </div>
                        </div>

                        <h2>Manage work schedule:</h2>
                        <div class="select-work-schedule">
                            <input type="checkbox" name="" id="mon" value="" checked>
                            <label for="mon">Monday</label>
                            
                            <input type="checkbox" name="" id="tue" value="" checked>
                            <label for="tue">Tuesday</label>

                            <input type="checkbox" name="" id="wed" value="" checked>
                            <label for="wed">Wednesday</label>

                            <input type="checkbox" name="" id="thu" value="" checked>
                            <label for="thu">Thursday</label><br>

                            <input type="checkbox" name="" id="fri" value="" checked>
                            <label for="fri">Friday</label>

                            <input type="checkbox" name="" id="sat" value="" checked>
                            <label for="sat">Saturday</label>

                            <input type="checkbox" name="" id="sun" value="">
                            <label for="sun">Sunday</label><br>

                            <label for="">From: </label>
                            <input type="time" name="" id=""  value="06:00">
                            <span>-</span>
                            <label for="">To: </label>
                            <input type="time" name="" id="" value="18:00">
                        </div>

                        <h2>Location/Landmark:</h2>
                        <div class="select-location">
                            <div class="form-group">
                                <input type="text" name="" id="" placeholder="Preferred work location" value="Near Treasa Garden">
                            </div>
                        </div>

                        <h2>About you:</h2>
                        <div class="about-me">
                            <div class="form-group">
                                <textarea name="" id="" maxlength="80" placeholder="Describe your handyman skills or specialties.
                                (max 80 characters)"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn" name="submit">Save</button>
                    </form>

                    <form class="account-delete" method="POST" onsubmit="return confirm('Are you sure you want to delete your WORK PROFILE?');">
                        <input type="hidden" name="" value="">
                        <button type="submit" name="submit">Delete Work Profile</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>