<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Message.class.php');
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

session_start();

function parseMessages(array $messages): array {
    $parsedMessages = array();
    
    foreach ($messages as $message) {
        $parsedMessage = array(
            'id' => $message->getId(),
            'datetime' => $message->getDatetime(),
            'content' => $message->getContent(),
            'sender' => $message->getSender()->getId(),
            'receiver' => $message->getReceiver()->getId(),        
        );
        
        $parsedMessages[] = $parsedMessage;
    }
    
    return $parsedMessages;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));
}

if (!isset($_GET['id'])){
    die(['success' => false, 'error' => 'Missing fields']);
}

if (!isset($_SESSION['user']['id'])) {
    die(['success' => false, 'error' => 'Not logged in']);
}

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $messages = Message::getMessages($db, User::getUserByID($db, (int)($_SESSION['user']['id'])), User::getUserByID($db, (int)($_GET['id'])), isset($_GET['lastId']) ? (int)($_GET['lastId']) : PHP_INT_MAX);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}


die(json_encode(['success' => true, 'messages' => parseMessages($messages)]));