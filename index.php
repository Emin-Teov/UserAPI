<?php

namespace DatabaseToAPI;

include __DIR__.'/SetDatabase.php';

// api: /users -- Select all users from users table
$api = new SetDatabase;

if($_GET["set"] === "user" && $_GET["id"]){
    // api: /user/{id} -- Select user from users table
    $api->selectDB($_GET["id"]);
}else if($_GET["set"] == "insert"){
    // api: /user/insert -- Insert user from users table
    // Check the token through the token table
    $api->insertDB(["name"=>$_POST["name"], "surname"=>$_POST["surname"], "email"=> $_POST["email"]], $_POST["token"]);
}else if($_GET["set"] == "update"){
    // api: /user/update -- Update user from users table
    // Check the token through the token table
    $api->updateDB($_POST["id"], ["name"=>$_POST["name"], "surname"=>$_POST["surname"], "email"=> $_POST["email"]], $_POST["token"]);
}else if($_GET["set"] == "delete"){
    // api: /user/delete -- Delete user from users table
    // Check the token through the token table
    $api->deleteDB($_POST["id"], $_POST["token"]);
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($api->setDB());