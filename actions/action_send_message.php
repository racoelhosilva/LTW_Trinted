<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Message.class.php');
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

function parseMessage(Message $message): array {
    $parsedMessage = array(
        'id' => $message->id,
        'datetime' => $message->datetime,
        'content' => $message->content,
        'sender' => $message->sender->id,
        'receiver' => $message->receiver->id,        
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
    $message = new Message(0, time(), $messageText, User::getUserByID($db, $_SESSION['user_id']), User::getUserByID($db, $destID));
    $message->upload($db);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}

die(json_encode(['success' => true, 'message' => parseMessage($message)]));