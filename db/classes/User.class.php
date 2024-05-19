<?php

declare(strict_types=1);

require_once __DIR__ . '/../../framework/Autoload.php';

class User
{
    private ?int $id;
    private string $name;
    private string $password;
    private int $registerDatetime;
    private Image $profilePicture;
    private string $type;
    private bool $isBanned;
    private string $email;

    public function __construct(?int $id, string $email, string $name, string $password, int $registerDatetime, Image $profilePicture, string $type)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->registerDatetime = $registerDatetime;
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
        if ($this->id == null) {
            $stmt = $db->prepare("INSERT INTO User (email, name, password, registerDatetime, profilePicture, type) VALUES (:email, :name, :password, :registerDateTime, :profilePicture, :type)");
        } else {
            $stmt = $db->prepare("INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type) VALUES (:id, :email, :name, :password, :registerDateTime, :profilePicture, :type)");
            $stmt->bindParam(":id", $this->id);
        }

        $profilePictureUrl = $this->profilePicture->getUrl();

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":registerDateTime", $this->registerDatetime);
        $stmt->bindParam(":profilePicture", $profilePictureUrl);
        $stmt->bindParam(":type", $this->type);
        $stmt->execute();

        if ($this->id == null) {
            $stmt = $db->prepare("SELECT last_insert_rowid()");
            $stmt->execute();
            $id = $stmt->fetch();
            $this->id = $id[0];
        }
    }

    public function getId(): ?int
    {
        return (int)$this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegisterDatetime(): int
    {
        return (int)$this->registerDatetime;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIsBanned(): bool
    {
        return (bool)$this->isBanned;
    }

    public function getProfilePicture(): Image
    {
        return $this->profilePicture;
    }

    public static function getNumberOfUsers(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM User");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }
    
    public static function getNumberOfActiveUsers(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM User WHERE NOT isBanned");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    public static function getNumberOfBannedUsers(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM User WHERE isBanned");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    public static function getNumberOfAdmins(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM User WHERE User.type == 'admin'");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    public static function getNumberOfSellers(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM User WHERE User.type == 'seller'");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    public static function getNumberOfBuyers(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM User WHERE User.type == 'buyer'");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    
    public static function getUserByID(PDO $db, int $id): ?User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user == false)
            return null;
        return new User($user["id"], $user["email"], $user["name"], $user["password"], $user["registerDatetime"], new Image($user["profilePicture"]), $user["type"]);
    }

    public static function getUserByEmail(PDO $db, string $email): ?User
    {
        $stmt = $db->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user == false) {
            return null;
        }
        return new User($user["id"], $user["email"], $user["name"], $user["password"], $user["registerDatetime"], new Image($user["profilePicture"]), $user["type"]);
    }

    public function setType(PDO $db, string $type): void
    {
        if (!in_array($type, ["seller", "buyer", "admin"])) {
            throw new Exception("Invalid type");
        }
        $this->type = $type;
        $stmt = $db->prepare("UPDATE User SET type = :type WHERE id = :id");
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function setName(PDO $db, string $name): void
    {
        $this->name = $name;
        $stmt = $db->prepare("UPDATE User SET name = :name WHERE id = :id");
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function setEmail(PDO $db, string $email): void
    {
        $this->email = $email;
        $stmt = $db->prepare("UPDATE User SET email = :email WHERE id = :id");
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function setPassword(PDO $db, string $password): void
    {
        $this->password = $password;
        $this->hashPassword();
        $stmt = $db->prepare("UPDATE User SET password = :password WHERE id = :id");
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function setProfilePicture(PDO $db, Image $image): void
    {
        $imageUrl = $image->getUrl();

        $stmt = $db->prepare("UPDATE User SET profilePicture = :profilePicture WHERE id = :id");
        $stmt->bindParam(":profilePicture", $imageUrl);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $this->profilePicture = $image;
    }

    public function getUserProducts(PDO $db): array
    {
        $stmt = $db->prepare("SELECT id FROM Product WHERE seller = :seller AND (payment IS NULL)");
        $stmt->bindParam(":seller", $this->id);
        $stmt->execute();
        $products = $stmt->fetchAll();
        $products = array_map(function ($product) use ($db) {
            return Product::getProductByID($db, $product["id"]);
        }, $products);
        $products = array_filter($products, function ($product) {
            return $product != null;
        });
        return $products;
    }

    public function getSoldItems(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM Product WHERE seller = :seller AND (NOT (payment IS NULL)) ");
        $stmt->bindParam(":seller", $this->id);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return array_map(function ($product) use ($db) {
            return Product::getProductByID($db, $product["id"], false);
        }, $products);
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

    public function getWishlist(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM Wishes WHERE user = :user");
        $stmt->bindParam(":user", $this->id);
        $stmt->execute();
        $wishlist = array_map(function ($productId) use ($db) {
            return Product::getProductByID($db, $productId["product"]);
        }, $stmt->fetchAll());
        $wishlist = array_filter($wishlist, function ($product) {
            return $product != null;
        });
        return $wishlist;
    }

    public function addToWishlist(PDO $db, Product $product): void
    {
        $productId = $product->getId();

        $stmt = $db->prepare("INSERT INTO Wishes (user, product) VALUES (:user, :product)");
        $stmt->bindParam(":user", $this->id);
        $stmt->bindParam(":product", $productId);
        $stmt->execute();
    }

    public function removeFromWishlist(PDO $db, Product $product): void
    {
        $productId = $product->getId();

        $stmt = $db->prepare("DELETE FROM Wishes WHERE user = :user AND product = :product");
        $stmt->bindParam(":user", $this->id);
        $stmt->bindParam(":product", $productId);
        $stmt->execute();
    }

    public function isInWishlist(PDO $db, Product $product): bool
    {
        $productId = $product->getId();

        $stmt = $db->prepare("SELECT * FROM Wishes WHERE user = :user AND product = :product");
        $stmt->bindParam(":user", $this->id);
        $stmt->bindParam(":product", $productId);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    public function delete(PDO $db): void {
        $stmt = $db->prepare("DELETE FROM User WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }
}
