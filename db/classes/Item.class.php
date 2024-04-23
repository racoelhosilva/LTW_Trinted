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
        $stmt = $db->prepare("INSERT INTO Item (name, seller, size, category, condition) VALUES (:name, :seller, :size, :category, :condition)");
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":seller", $this->seller->username);
        $stmt->bindParam(":size", $this->size->size);
        $stmt->bindParam(":category", $this->category->category);
        $stmt->bindParam(":condition", $this->condition->condition);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getBrands(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM ItemBrand WHERE item = :item");
        $stmt->bindParam(":item", $this->id);
        $stmt->execute();
        $itemBrands = $stmt->fetchAll();
        return array_map(function ($itemBrand) use ($db) {
            return new Brand($itemBrand["brand"]);
        }, $itemBrands);
    }

    public static function getItem(PDO $db, int $id): Item
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

    public static function getNItems(PDO $db, int $n): array
    {
        $stmt = $db->prepare("SELECT * FROM Item WHERE id <= :n");
        $stmt->bindParam(":n", $n);
        $stmt->execute();
        $items = $stmt->fetchAll();
        return array_map(function ($item) use ($db) {
            print("found\n");
            return new Item($item["id"], $item["name"], User::getUser($db, $item["seller"]), Size::getSize($db, $item["size"]), Category::getCategory($db, $item["category"]), Condition::getCondition($db, $item["condition"]));
        }, $items);
    }
}
