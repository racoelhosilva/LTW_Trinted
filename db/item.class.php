<?php

declare(strict_types=1);

class Item
{
    public int $id;
    public string $name;
    public User $seller;
    public Size $size;
    public Category $category;
    public Condition $condition;
    public function __construct(int $id, string $name, User $seller, Size $size, Category $category, Condition $condition)
    {
        $this->id = $id;
        $this->name = $name;
        $this->seller = $seller;
        $this->size = $size;
        $this->category = $category;
        $this->condition = $condition;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Item (id, name, seller, size, category, condition) VALUES (:id, :name, :seller, :size, :category, :condition)");
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":seller", $this->seller->username);
        $stmt->bindParam(":size", $this->size->size);
        $stmt->bindParam(":category", $this->category->category);
        $stmt->bindParam(":condition", $this->condition->condition);
        $stmt->execute();
    }

    public static function getItem(PDO $db, string $id)
    {
        $stmt = $db->prepare("SELECT * FROM Item WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $itemData = $stmt->fetch();
        if ($itemData === false) {
            throw new Exception("Item not found");
        }
        return new Item($itemData["id"], $itemData["name"], User::getUser($db, $itemData["seller"]), Size::getSize($db, $itemData["size"]), Category::getCategory($db, $itemData["category"]), Condition::getCondition($db, $itemData["condition"]));
    }
}
