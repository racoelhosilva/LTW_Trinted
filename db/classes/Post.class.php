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
        $stmt->bindParam(":seller", $this->seller->username);
        $stmt->bindParam(":item", $this->item->id);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getAllImages(PDO $db): array{
        $stmt = $db->prepare("SELECT * FROM PostImage WHERE post = :post");
        $stmt->bindParam(":post", $this->id);
        $stmt->execute();
        $images = $stmt->fetchAll();
        return array_map(function ($image) use ($db) {
            return new Image($image["image"]);
        }, $images);
    }
}
