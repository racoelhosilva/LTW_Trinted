<?php

declare(strict_types=1);

class Post
{
    public int $id;
    public string $title;
    public float $price;
    public string $description;
    public int $publishDateTime;
    public User $seller;
    public Item $item;

    public function __construct(int $id, string $title, float $price, string $description, int $publishDateTime, User $seller, Item $item)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->publishDateTime = $publishDateTime;
        $this->seller = $seller;
        $this->item = $item;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Post (title, price, description, publishDatetime, seller, item) VALUES (:title, :price, :description, :publishDateTime, :seller, :item)");
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":publishDateTime", $this->publishDateTime);
        $stmt->bindParam(":seller", $this->seller->id);
        $stmt->bindParam(":item", $this->item->id);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getAllImages(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM PostImage WHERE post = :post");
        $stmt->bindParam(":post", $this->id);
        $stmt->execute();
        $images = $stmt->fetchAll();
        return array_map(function ($image) use ($db) {
            return new Image($image["image"]);
        }, $images);
    }

    public function getItem(PDO $db): Item
    {
        return Item::getItem($db, $this->item->id);
    }

    public static function getPostByID(PDO $db, int $id): ?Post
    {
        $stmt = $db->prepare("SELECT * FROM Post WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $post = $stmt->fetch();
        if (!isset($post["id"]))
            return null;
        return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]));
    }

    public static function getPostsByCategory(PDO $db, Category $category): array{
        $stmt = $db->prepare("SELECT * FROM Post WHERE item IN (SELECT id FROM Item WHERE category = :category)");
        $stmt->bindParam(":category", $category->category);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]));
        }, $posts);
    }

    public static function getPostsByBrand(PDO $db, Brand $brand) : array {
        $stmt = $db->prepare("SELECT * FROM Post WHERE item IN (SELECT item FROM ItemBrand WHERE brand = :brand)");
        $stmt->bindParam(":brand", $brand->name);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]));
        }, $posts);
    }

    public static function getNPosts(PDO $db, int $n): array
    {
        $stmt = $db->prepare("SELECT * FROM Post WHERE id <= :n");
        $stmt->bindParam(":n", $n);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return array_map(function ($post) use ($db) {
            return new Post($post["id"], $post["title"], $post["price"], $post["description"], strtotime($post["publishDatetime"]), User::getUserByID($db, $post["seller"]), Item::getItem($db, $post["item"]));
        }, $posts);
    }
}
