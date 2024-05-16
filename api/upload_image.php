<?php
declare(strict_types=1);

$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

if (!is_dir('../images')) mkdir('../images');
if (!is_dir('../images/posts')) mkdir('../images/posts');
if (!is_dir('../images/profiles')) mkdir('../images/profiles');

// image is the name of the input in the form
$tempFileName = $_FILES['image']['tmp_name'];
die(json_encode($tempFileName));
$image = @imagecreatefromjpeg($tempFileName);
if (!$image) $image = @imagecreatefrompng($tempFileName);
if (!$image) $image = @imagecreatefromgif($tempFileName);

if (!$image) {
    die(json_encode(array('status' => 'error', 'message' => 'Unknown image format!')));
}

$subfolder = $_POST['subfolder'] ?? null;

if ($subfolder === null) {
    die(json_encode(array('status' => 'error', 'message' => 'Subfolder not specified!')));
}

if ($subfolder !== 'posts' && $subfolder !== 'profiles') {
    die(json_encode(array('status' => 'error', 'message' => 'Wrong subfolder!')));
}

$filename = "images/" . $subfolder . "/" . uniqid() . ".jpg";
$stmt = $db->prepare("INSERT INTO Image (url) VALUES (:url)");
$stmt->bindParam(":url", $filename);

try {
    $stmt->execute();
} catch (PDOException $e) {
    die(json_encode(array('status' => 'error', 'message' => 'Unable to upload image!')));
}


imagejpeg($image, $_SERVER['DOCUMENT_ROOT'] . "/" . $filename);
die(json_encode(array('status' => 'success', "message" => "Image uploaded successfully!")));



