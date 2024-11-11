<?php
require 'config/database.php';

//destroy all sessions and redirect to login page
session_unset();
session_destroy();
header('location: ' . ROOT_URL . 'signin.php');
die();