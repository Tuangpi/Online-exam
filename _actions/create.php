<?php
include("../vendor/autoload.php");

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$data = [
    ":name" => $_POST['name'] ?? "Unknown",
    ":email" => $_POST['email'] ?? "Unknown",
    ":phone_number" => $_POST['phone'] ?? "Unknown",
    ":password" => md5($_POST['password']),
    ":address" => $_POST['address'] ?? "Unknown",
    ":gender" => $_POST['gender'] ?? "Unknown",
    ":college" => $_POST['college'] ?? "Unknown",
];

$table = new UsersTable(new MySQL());

$user = $table->findByEmailAndPassword($_POST['email'], md5($_POST['password']));

if($user){
    HTTP::redirect("register.php", "registered=false");
}else{
    $table->insert($data);
    HTTP::redirect("index.php");
}