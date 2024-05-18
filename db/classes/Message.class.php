<?php

declare(strict_types=1);

class Message
{
    public int $id;
    public int $datetime;
    public string $content;
    public User $sender;
    public User $receiver;
    public function __construct(int $id, int $datetime, string $content, User $sender, User $receiver)
    {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->content = $content;
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    public function upload(PDO $db)
    {
        $senderId = $this->sender->getId();
        $receiverId = $this->receiver->getId();

        $stmt = $db->prepare("INSERT INTO Message (datetime, content, sender, receiver) VALUES (:datetime, :content, :sender, :receiver)");
        $stmt->bindParam(":datetime", $this->datetime);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":sender", $senderId);
        $stmt->bindParam(":receiver", $receiverId);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public static function getMessages(PDO $db, User $user1, User $user2, int $lastId) {
        $userId1 = $user1->getId();
        $userId2 = $user2->getId();

        $stmt = $db->prepare("SELECT * FROM Message WHERE (id < :last_id) AND ((sender == :user1 AND receiver == :user2) OR (sender == :user2 AND receiver == :user1)) ORDER BY datetime DESC LIMIT 16");
        $stmt->bindParam(":user1", $userId1);
        $stmt->bindParam(":user2", $userId2);
        $stmt->bindParam(":last_id", $lastId);
        $stmt->execute();
        $messages = $stmt->fetchAll();
        return $messages;
    }

    public static function getRecentContacts(PDO $db, User $user) {
        $userId = $user->getId();

        $stmt = $db->prepare("SELECT DISTINCT sender FROM Message WHERE receiver == :user ORDER BY datetime ASC");
        $stmt->bindParam(":user", $userId);
        $stmt->execute();
        $contacts = $stmt->fetchAll();
        return $contacts;
    }
}
