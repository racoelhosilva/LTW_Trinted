<?php

declare(strict_types=1);

class Size
{
    public string $size;
    public function __construct(string $size){
        $this->size = $size;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Size (size) VALUES (:size)");
        $stmt->bindParam(":size", $this->size);
        $stmt->execute();
    }

}