<?php

declare(strict_types=1);

class Size
{
    public string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Size (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();
    }

    public static function getSize(PDO $db, string $size): Size
    {
        // At first glance, going to the database if we already now the size
        // might seem a bit stupid, but in this way we can check
        // if the size is in the database or not.
        $stmt = $db->prepare("SELECT name FROM Size WHERE name = :size");
        $stmt->bindParam(":size", $size);
        $stmt->execute();
        $sizeName = $stmt->fetch();
        if ($sizeName === false) {
            throw new Exception("Size not found");
        }
        return new Size($sizeName["name"]);
    }

    public static function getAll(PDO $db): array
    {
        $stmt = $db->prepare("SELECT name FROM Size");
        $stmt->execute();
        $sizes = array_map(function ($size) {
            return new Size($size["name"]);
        }, $stmt->fetchAll());
        return $sizes;
    }
}
