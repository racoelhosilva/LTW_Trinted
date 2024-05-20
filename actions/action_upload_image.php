<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/../db/utils.php';

$request = new Request();
$db = getDatabaseConnection();

if ($request->getMethod() !== 'POST') {
    sendMethodNotAllowed();
}
if (!$request->paramsExist(['subfolder']) || $request->files('image') == null) {
    sendMissingFields();
}

if (!is_dir('../images')) mkdir('../images');
if (!is_dir('../images/posts')) mkdir('../images/posts');
if (!is_dir('../images/profiles')) mkdir('../images/profiles');

// image is the name of the input in the form
$tempFileName = $request->files('image')['tmp_name'];

$image = @imagecreatefromjpeg($tempFileName);
if (!$image) $image = @imagecreatefrompng($tempFileName);
if (!$image) $image = @imagecreatefromgif($tempFileName);

if (!$image) {
    sendBadRequest('Unknown image format!');
}

$subfolder = $request->post('subfolder');

if ($subfolder !== 'posts' && $subfolder !== 'profiles') {
    sendBadRequest('Invalid subfolder!');
}

$filename = "/images/" . $subfolder . "/" . uniqid() . ".jpg";

try {
    $stmt = $db->prepare("INSERT INTO Image (url) VALUES (:url)");
    $stmt->bindParam(":url", $filename);
    $stmt->execute();
} catch (PDOException $e) {
    error_log($e->getMessage());
    sendInternalServerError();
}

imagejpeg($image, $_SERVER['DOCUMENT_ROOT'] . $filename);
sendOk(['path' => $filename]);



