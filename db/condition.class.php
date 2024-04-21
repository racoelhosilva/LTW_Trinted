<?php

declare(strict_types=1);

class Condition
{
    public string $condition;
    public function __construct(string $condition)
    {
        $this->condition = $condition;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Condition (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->condition);
        $stmt->execute();
    }

    public static function getCondition(PDO $db, string $condition)
    {
        // At first glance, going to the database if we already now the size
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
}
