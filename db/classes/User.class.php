<?php

declare(strict_types=1);

require_once 'Image.class.php';
class User
{
    public int $id;
    public string $email;
    public string $name;
    public string $password;
    public int $registerDateTime;
    public Image $profilePicture;
    public string $type;
    public bool $isBanned;

    public function __construct(int $id, string $email, string $name, string $password, int $registerDateTime, Image $profilePicture, string $type)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->registerDateTime = $registerDateTime;
        $this->profilePicture = $profilePicture;
        $this->type = $type;
        $this->isBanned = false;
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT, ['cost' >= 12]);
    }
    public function upload(PDO $db): void
    {
        $stmt = $db->prepare("INSERT INTO User (email, name, password, registerDatetime, profilePicture, type) VALUES (:email, :name, :password, :registerDateTime, :profilePicture, :type)");
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":registerDateTime", $this->registerDateTime);
        $stmt->bindParam(":profilePicture", $this->profilePicture->url);
        $stmt->bindParam(":type", $this->type);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public static function getUserByID(PDO $db, int $id): User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user === false) {
            throw new Exception("User not found");
        }
        return new User($user["id"], $user["email"], $user["name"], $user["password"], $user["registerDatetime"], new Image($user["profilePicture"]), $user["type"]);
    }

    public static function getUserByEmail(PDO $db, string $email): User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user === false) {
            throw new Exception("User not found");
        }
        return new User($user["id"], $user["email"], $user["name"], $user["password"], $user["registerDatetime"], new Image($user["profilePicture"]), $user["type"]);
    }

    public function getProfilePicture(PDO $db): Image
    {
        $stmt = $db->prepare("SELECT profilePicture FROM User WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $profilePicture = $stmt->fetch();
        if ($profilePicture === false) {
            throw new Exception("No image found");
        }
        return new Image($profilePicture["profilePicture"]);
    }

    public function setType(PDO $db, string $type): void
    {
        // if name not int ["seller", "buyer", "admin"] stop
        if (!in_array($type, ["seller", "buyer", "admin"])) {
            throw new Exception("Invalid type");
        }
        $this->type = $type;
        $stmt = $db->prepare("UPDATE User SET type = :type WHERE id = :id");
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function getUserPosts(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM Post WHERE seller = :seller");
        $stmt->bindParam(":seller", $this->id);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), $this, Item::getItem($db, $post["item"]));
        }, $posts);
    }

    public function isBanned(PDO $db): bool
    {
        $stmt = $db->prepare("SELECT isBanned FROM User WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $isBanned = $stmt->fetch();
        if ($isBanned === false) {
            throw new Exception("User not found");
        }
        $this->isBanned = boolval($isBanned["isBanned"]);
        return boolval($isBanned["isBanned"]);
    }

    public function ban(PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET isBanned = 1 WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->isBanned = true;
    }
    public function unban(PDO $db): void
    {
        $stmt = $db->prepare("UPDATE User SET isBanned = 0 WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $this->isBanned = false;
    }
}
