<?php
// ************ This file is used only for testing the database ************


$db = new PDO("sqlite:database.db");
// $image = new Image("https://picsum.photos/1600/1200");
// $image->upload($db);
// $user = new User("john_doe", "john@gmail.com", "John Doe", "password123", time(), $image, "seller");
// $user->hashPassword();
// $user->upload($db);
// //$user = User::getUser($db, "john_doe");
// // $user->upload($db);
//  $size = new Size("M");
// $category = new Category("T-shirt");
// $condition = new Condition("Used");
// $size->upload($db);
// $category->upload($db);
// $condition->upload($db);
// //$user->setType($db, "seller");
// $item = new Item(1, "item1", $user, $size, $category, $condition);
// $item->upload($db);
// // $item = Item::getItem($db, 1);
$items = Item::getNItems($db, 10);
foreach ($items as $item){
    print($item->name);
}