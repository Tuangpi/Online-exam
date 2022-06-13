<?php
session_start();
include("../vendor/autoload.php");

use Helpers\HTTP;

unset($_SESSION['user']);
unset($_SESSION['admin']);

HTTP::redirect("index.php");
