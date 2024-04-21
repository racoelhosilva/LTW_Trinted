<?php

declare(strict_types=1);

class Image
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function upload(PDO $db)
    {
        $stmt = $db->prepare("INSERT INTO Image (url) VALUES (:url)");
        $stmt->bindParam(":url", $this->url);
        $stmt->execute();
    }
}
