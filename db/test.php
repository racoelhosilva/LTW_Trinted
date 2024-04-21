<?php

require_once "user.class.php";
require_once "image.class.php";

$db = new PDO("sqlite:database.db");
$image = new Image("https://picsum.photos/1600/1200");
$image->upload($db);
$user = new User("john_doe", "john@gmail.com", "John Doe", "password", time(), $image, "buyer");
$user->upload($db);
//$user = User::getUser($db, "john_doe");
//$user->setType($db, "seller");