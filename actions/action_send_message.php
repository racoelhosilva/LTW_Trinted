<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/utils.php';

function parseMessage(Message $message): array {
    $parsedMessage = array(
        'id' => $message->getId(),
        'datetime' => $message->getDatetime(),
        'content' => $message->getContent(),
        'sender' => $message->getSender()->getId(),
        'receiver' => $message->getReceiver()->getId(),        
    );
    return $parsedMessage;
}


if (!isset($_POST['message']) || $_POST['message'] == "" || !isset($_POST['destID']))
    die("Invalid request");

session_start();


$messageText = sanitize($_POST['message']);
$destID = (int)(sanitize($_POST['destID']));
$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');


try {
    $message = new Message(0, time(), $messageText, User::getUserByID($db, $_SESSION['user']['id']), User::getUserByID($db, $destID));
    $message->upload($db);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}

die(json_encode(['success' => true, 'message' => parseMessage($message)]));