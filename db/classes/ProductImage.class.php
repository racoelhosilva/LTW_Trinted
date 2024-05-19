<?php
declare(strict_types=1);

require_once __DIR__ . '/Product.class.php';
require_once __DIR__ . '/Image.class.php';

class ProductImage {
    public Product $product;
    public Image $image;

    public function __construct(Product $product, Image $image){
        $this->product = $product;
        $this->image = $image;
    }

    public function upload(PDO $db){
        $productId = $this->product->getId();
        $imageUrl = $this->image->getUrl();

        $stmt = $db->prepare("INSERT INTO ProductImage (product, image) VALUES (:product, :image)");
        $stmt->bindParam(":product", $productId);
        $stmt->bindParam(":image", $imageUrl);
        $stmt->execute();
    }

    public function delete(PDO $db): void {
        $productId = $this->product->getId();
        $imageUrl = $this->image->getUrl();

        $stmt = $db->prepare("DELETE FROM ProductImage WHERE product = :product AND image = :image");
        $stmt->bindParam(":product", $productId);
        $stmt->bindParam(":image", $imageUrl);
        $stmt->execute();
    }
}