<?php

declare(strict_types=1);

class Brand {
    private string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    public function getName(): string{
        return $this->name;
    }

    public function upload(PDO $db){
        $stmt = $db->prepare("INSERT INTO Brand (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();
    }

    public static function getAllBrands(PDO $db) {
        $stmt = $db->prepare("SELECT name FROM Brand ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getNumberOfBrands(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM Brand");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    public static function getBrand(PDO $db, string $name): Brand{
        $stmt = $db->prepare("SELECT * FROM Brand WHERE name = :name ");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $brand = $stmt->fetch();
        if ($brand === false){
            throw new Exception("Brand not found");
        }
        return new Brand($brand["name"]);
    }

    public static function getAll(PDO $db): array{
        $stmt = $db->prepare("SELECT name FROM Brand");
        $stmt->execute();
        $brands = array_map(function($brand){
            return new Brand($brand["name"]);
        }, $stmt->fetchAll());
        return $brands;
    }
}