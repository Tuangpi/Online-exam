<?php
session_start();
include("../vendor/autoload.php");

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;


$email = $_POST['email'];
$password = md5($_POST['password']);

$table = new UsersTable(new MySQL());

$user = $table->findByEmailAndPassword($email, $password);

if ($email === "admin@gmail.com" and $password === "81dc9bdb52d04dc20036dbd8313ed055") {          //admin password = 1234
    $_SESSION['admin'] = "admin";
    HTTP::redirect("dashboard.php", "logged=admin");
} elseif ($user) {
    $_SESSION['user'] = $user;
    HTTP::redirect("dashboard.php", "logged=user");
} else {
    HTTP::redirect("index.php", "incorrect=1");
}
