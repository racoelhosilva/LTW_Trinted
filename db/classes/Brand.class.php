<?php

declare(strict_types=1);

class Brand {
    public string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    public function upload(PDO $db){
        $stmt = $db->prepare("INSERT INTO Brand (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();
    }

    public static function getBrand(PDO $db, string $name): Brand{
        $stmt = $db->prepare("SELECT * FROM Item WHERE name = :name ");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $brand = $stmt->fetch();
        if ($brand === false){
            throw new Exception("Brand not found");
        }
        return new Brand($brand["name"]);
    }

}