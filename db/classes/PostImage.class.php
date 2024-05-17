<?php

declare(strict_types=1);

class ProductImage {
    public Product $product;
    public Image $image;

    public function __construct(Product $product, Image $image){
        $this->product = $product;
        $this->image = $image;
    }

    public function upload(PDO $db){
        $stmt = $db->prepare("INSERT INTO ProductImage (product, image) VALUES (:product, :image)");
        $stmt->bindParam(":product", $this->product->id);
        $stmt->bindParam(":image", $this->image->url);
        $stmt->execute();
    }
}