<?php
declare(strict_types=1);

require_once __DIR__ . '/Product.class.php';
require_once __DIR__ . '/Brand.class.php';

class ProductBrand {
    public Product $product;
    public Brand $brand;

    public function __construct(Product $product, Brand $brand){
        $this->product = $product;
        $this->brand = $brand;
    }

    public function upload(PDO $db){
        $productId = $this->product->getId();
        $brandName = $this->brand->getName();

        $stmt = $db->prepare("INSERT INTO ProductBrand (item, brand) VALUE (:item, :brand)");
        $stmt->bindParam(":item", $productId);
        $stmt->bindParam(":brand", $brandName);
    }
}