<?php

declare(strict_types=1);

class Category
{
    public string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Category (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();
    }

    public static function getCategory(PDO $db, string $category): Category
    {
        // At first glance, going to the database if we already now the category
        // might seem a bit stupid, but in this way we can check
        // if the category is in the database or not.
        $stmt = $db->prepare("SELECT name FROM Category WHERE name = :category");
        $stmt->bindParam(":category", $category);
        $stmt->execute();
        $categoryName = $stmt->fetch();
        if ($categoryName === false) {
            throw new Exception("Category not found");
        }
        return new Category($categoryName["name"]);
    }

    public static function getAll(PDO $db): array
    {
        $stmt = $db->prepare("SELECT name FROM Category");
        $stmt->execute();
        $categories = array_map(function ($category) {
            return new Category($category["name"]);
        }, $stmt->fetchAll());
        return $categories;
    }
}
