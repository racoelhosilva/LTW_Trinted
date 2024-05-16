<?php

declare(strict_types=1);

include_once(__DIR__ . "/User.class.php");
include_once(__DIR__ . "/Item.class.php");
include_once(__DIR__ . "/Payment.class.php");

class Post
{
    public int $id;
    public string $title;
    public float $price;
    public string $description;
    public int $publishDateTime;
    public User $seller;
    public Item $item;
    public ?Payment $payment = null;

    public function __construct(int $id, string $title, float $price, string $description, int $publishDateTime, User $seller, Item $item, ?Payment $payment = null) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->publishDateTime = $publishDateTime;
        $this->seller = $seller;
        $this->item = $item;
        $this->payment = $payment;
    }

    public function upload(PDO $db) {
        $stmt = $db->prepare("INSERT INTO Post (title, price, description, publishDatetime, seller, item, payment) VALUES (:title, :price, :description, :publishDateTime, :seller, :item, :payment)");
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":publishDateTime", $this->publishDateTime);
        $stmt->bindParam(":seller", $this->seller->id);
        $stmt->bindParam(":item", $this->item->id);
        $stmt->bindParam(":payment", $this->payment->id);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getAllImages(PDO $db): array {
        $stmt = $db->prepare("SELECT * FROM PostImage WHERE post = :post");
        $stmt->bindParam(":post", $this->id);
        $stmt->execute();
        $images = $stmt->fetchAll();
        return array_map(function ($image) use ($db) {
            return new Image($image["image"]);
        }, $images);
    }

    public function getItem(PDO $db): Item {
        return Item::getItem($db, $this->item->id);
    }

    public static function getPostByID(PDO $db, int $id, bool $onlyValid = true): ?Post {
        $stmt = $db->prepare("SELECT * FROM Post WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $post = $stmt->fetch();
        if (!isset($post["id"]))
            return null;
        if ($onlyValid && isset($post["payment"]))
            return null;
        return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]), isset($post["payment"]) ? Payment::getPaymentById($db, $post["payment"]) : null);
    }

    public static function getPostsByCategory(PDO $db, Category $category, bool $onlyValid = true): array {
        $stmt = $db->prepare("SELECT * FROM Post WHERE item IN (SELECT id FROM Item WHERE category = :category)");
        $stmt->bindParam(":category", $category->category);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        if ($onlyValid) {
            $posts = array_filter($posts, function ($post) {
                return $post["payment"] == null;
            });
        }
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]), isset($post["payment"]) ? Payment::getPaymentById($db, $post["payment"]) : null);
        }, $posts);
    }

    public static function getPostsByBrand(PDO $db, Brand $brand, bool $onlyValid = true) : array {
        $stmt = $db->prepare("SELECT * FROM Post WHERE item IN (SELECT item FROM ItemBrand WHERE brand = :brand)");
        $stmt->bindParam(":brand", $brand->name);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        if ($onlyValid) {
            $posts = array_filter($posts, function ($post) {
                return $post["payment"] == null;
            });
        }
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]), isset($post["payment"]) ? Payment::getPaymentById($db, $post["payment"]) : null);
        }, $posts);
    }

    public static function getNPosts(PDO $db, int $n, bool $onlyValid = true): array {
        $stmt = $db->prepare("SELECT * FROM Post WHERE id <= :n");
        $stmt->bindParam(":n", $n);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        if ($onlyValid) {
            $posts = array_filter($posts, function ($post) {
                return $post["payment"] == null;
            });
        }
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]), isset($post["payment"]) ? Payment::getPaymentById($db, $post["payment"]) : null);
        }, $posts);
    }

    public static function getAllPosts(PDO $db, bool $onlyValid = true): array {
        $stmt = $db->prepare("SELECT * FROM Post");
        $stmt->execute();
        $posts = $stmt->fetchAll();
        if ($onlyValid) {
            $posts = array_filter($posts, function ($post) {
                return $post["payment"] == null;
            });
        }
        return array_map(function ($post) use ($db) {
            return new Post(
                $post["id"],
                $post["title"],
                $post["price"],
                $post["description"],
                strtotime($post["publishDatetime"]),
                User::getUserByID($db, $post["seller"]),
                Item::getItem($db, $post["item"]),
                isset($post["payment"]) ? Payment::getPaymentById($db, $post["payment"]) : null,
            );
        }, $posts);
    }

    public function associateToPayment(PDO $db, int $paymentId): void {
        $stmt = $db->prepare("UPDATE Post SET payment = :paymentId WHERE id = :postId");
        $stmt->bindParam(":paymentId", $paymentId);
        $stmt->bindParam(":postId", $this->id);
        $stmt->execute();
        $this->payment = Payment::getPaymentById($db, (int)$paymentId);
    }
}
