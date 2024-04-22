<?php
// ************ This file is used only for testing the database ************
require_once "user.class.php";
require_once "image.class.php";
require_once "size.class.php";
require_once "category.class.php";
require_once "condition.class.php";
require_once "item.class.php";


$db = new PDO("sqlite:database.db");
//$image = new Image("https://picsum.photos/1600/1200");
//$image->upload($db);
//$user = new User("john_doe", "john@gmail.com", "John Doe", "password123", time(), $image, "seller");
//$user->hashPassword();
//$user->upload($db);
$user = User::getUser($db, "john_doe");
// $user->upload($db);
// $size = new Size("M");
// $category = new Category("T-shirt");
// $condition = new Condition("Used");
// $size->upload($db);
// $category->upload($db);
// $condition->upload($db);
// //$user->setType($db, "seller");
// $item = new Item(1, "item1", $user, $size, $category, $condition);
// $item->upload($db);
// $item = Item::getItem($db, 1);
print($user->validatePassword("password123"));
