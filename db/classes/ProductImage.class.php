<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';

class ProductImage {
    private Product $product;
    private Image $image;

    public function __construct(Product $product, Image $image){
        $this->product = $product;
        $this->image = $image;
    }

    public function getProduct(): Product {
        return $this->product;
    }

    public function getImage(): Image {
        return $this->image;
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