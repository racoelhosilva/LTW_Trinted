<?php
// ************ This file is used only for testing the database ************

require_once("classes/Brand.class.php");
require_once("classes/Category.class.php");
require_once("classes/Condition.class.php");
require_once("classes/Image.class.php");
require_once("classes/Item.class.php");
require_once("classes/ItemBrand.class.php");
require_once("classes/Size.class.php");
require_once("classes/User.class.php");
require_once("classes/Product.class.php");
$db = new PDO("sqlite:database.db");
// $image = new Image("https://picsum.photos/1600/1200");
// $image->upload($db);
// $user = new User("john_doe", "john@gmail.com", "John Doe", "password123", time(), $image, "seller");
// $user->hashPassword();
// $user->upload($db);
//$user = User::getUser($db, "john_doe");
// // $user->upload($db);
// $size = new Size("M");
// $category = new Category("T-shirt");
// $condition = new Condition("Used");
// $size->upload($db);
// $category->upload($db);
// $condition->upload($db);
// $user->setType($db, "seller");
// $item = new Item(20, "item20", $user, $size, $category, $condition);
// $item->upload($db);
// // $item = Item::getItem($db, 1);
// $items = Item::getNItems($db, 10);
// foreach ($items as $item){
//     print($item->name);
// }
// $item = Item::getItem($db, 2);
// $brands = $item->getBrands($db);
// foreach ($brands as $brand){
//     print($brand->name . "\n");
// }
//$item = Item::getItem($db, 2);
$image = new Image("https://ibb.co/YNSXPCY");
$image->upload($db);
$user = new User('AnalyticalT', "202208700@up.pt", "Bruno Oliveira", "123456", strtotime("2024-04--23 13:49:12"), $image, "seller");
$user->hashPassword();
$user->upload($db);
print($user->password . "\n");
