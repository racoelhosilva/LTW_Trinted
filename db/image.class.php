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
    public static function getImage(PDO $db, string $url){
        // At first glance, going to the database if we already now the size
        // might seem a bit stupid, but in this way we can check
        // if the image is in the database or not.
        $stmt = $db->prepare("SELECT url FROM Image WHERE url = :url");
        $stmt->bindParam(":url", $url);
        $stmt->execute();
        $urlName = $stmt->fetch();
        if ($urlName === false) {
            throw new Exception("Image not found");
        }
        return new Image($urlName["url"]);
    }
}
