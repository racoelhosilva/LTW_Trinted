<?php

declare(strict_types=1);

class Condition
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Condition (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();
    }
    
    public static function getAllConditions(PDO $db) {
        $stmt = $db->prepare("SELECT name FROM Condition");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getNumberOfConditions(PDO $db) {
        $stmt = $db->prepare("SELECT COUNT(*) AS cnt FROM Condition");
        $stmt->execute();
        return $stmt->fetch()['cnt'];
    }

    public static function getCondition(PDO $db, string $condition): Condition
    {
        // At first glance, going to the database if we already now the condition
        // might seem a bit stupid, but in this way we can check
        // if the condition is in the database or not.
        $stmt = $db->prepare("SELECT name FROM Condition WHERE name = :condition");
        $stmt->bindParam(":condition", $condition);
        $stmt->execute();
        $conditionName = $stmt->fetch();
        if ($conditionName === false) {
            throw new Exception("Condition not found");
        }
        return new Condition($conditionName["name"]);
    }

    public static function getAll(PDO $db): array
    {
        $stmt = $db->prepare("SELECT name FROM Condition");
        $stmt->execute();
        $conditions = array_map(function ($condition) {
            return new Condition($condition["name"]);
        }, $stmt->fetchAll());
        return $conditions;
    }
}
