<?php

declare(strict_types=1);

include_once(__DIR__ . "/User.class.php");
include_once(__DIR__ . "/Payment.class.php");

class Product
{
    public int $id;
    public string $title;
    public float $price;
    public string $description;
    public int $publishDateTime;
    public User $seller;
    public Size $size;
    public Category $category;
    public Condition $condition;
    public ?Payment $payment = null;

    public function __construct(int $id, string $title, float $price, string $description, int $publishDateTime, User $seller, Size $size, Category $category, Condition $condition, ?Payment $payment = null) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->publishDateTime = $publishDateTime;
        $this->seller = $seller;
        $this->size = $size;
        $this->category = $category;
        $this->condition = $condition;
        $this->payment = $payment;
    }

    public function upload(PDO $db) {
        $stmt = $db->prepare("INSERT INTO Product (title, price, description, publishDatetime, seller, size, category, condition, payment)
            VALUES (:title, :price, :description, :publishDateTime, :seller, :size, :category, :condition, :payment)");
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":publishDateTime", $this->publishDateTime);
        $stmt->bindParam(":seller", $this->seller->id);
        $stmt->bindParam(":size", $this->size->name);
        $stmt->bindParam(":category", $this->category->name);
        $stmt->bindParam(":condition", $this->condition->name);
        $stmt->bindParam(":payment", $this->payment->id);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getBrands(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM ProductBrand WHERE product = :product");
        $stmt->bindParam(":product", $this->id);
        $stmt->execute();
        $productBrands = $stmt->fetchAll();
        return array_map(function ($productBrand) use ($db) {
            return new Brand($productBrand["brand"]);
        }, $productBrands);
    }

    public function getAllImages(PDO $db): array {
        $stmt = $db->prepare("SELECT * FROM ProductImage WHERE product = :product");
        $stmt->bindParam(":product", $this->id);
        $stmt->execute();
        $images = $stmt->fetchAll();
        return array_map(function ($image) use ($db) {
            return new Image($image["image"]);
        }, $images);
    }

    private static function rowToProduct(array $row, PDO $db): Product {
        return new Product(
            $row["id"],
            $row["title"],
            $row["price"],
            $row["description"],
            strtotime($row["publishDatetime"]),
            User::getUserByID($db, $row["seller"]),
            Size::getSize($db, $row["size"]),
            Category::getCategory($db, $row["category"]),
            Condition::getCondition($db, $row["condition"]),
            isset($row["payment"]) ? Payment::getPaymentById($db, $row["payment"]) : null,
        );
    }

    public static function getProductByID(PDO $db, int $id, bool $onlyValid = true): ?Product {
        $stmt = $db->prepare("SELECT * FROM Product WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $product = $stmt->fetch();
        if (!isset($product["id"]))
            return null;
        if ($onlyValid && isset($product["payment"]))
            return null;
        return Product::rowToProduct($product, $db);
    }

    public static function getProductsByCategory(PDO $db, Category $category, bool $onlyValid = true): array {
        $stmt = $db->prepare("SELECT * FROM Product WHERE category = :category");
        $stmt->bindParam(":category", $category->name);
        $stmt->execute();
        $products = $stmt->fetchAll();
        if ($onlyValid) {
            $products = array_filter($products, function ($product) {
                return $product["payment"] == null;
            });
        }
        return array_map(function ($product) use ($db) {
            return Product::rowToProduct($product, $db);
        }, $products);
    }

    public static function getProductsByBrand(PDO $db, Brand $brand, bool $onlyValid = true) : array {
        $stmt = $db->prepare("SELECT * FROM Product WHERE id IN (SELECT product FROM ProductBrand WHERE brand = :brand)");
        $stmt->bindParam(":brand", $brand->name);
        $stmt->execute();
        $products = $stmt->fetchAll();
        if ($onlyValid) {
            $products = array_filter($products, function ($product) {
                return $product["payment"] == null;
            });
        }
        return array_map(function ($product) use ($db) {
            return Product::rowToProduct($product, $db);
        }, $products);
    }

    public static function getNProducts(PDO $db, int $n, bool $onlyValid = true): array {
        $stmt = $db->prepare("SELECT * FROM Product WHERE id <= :n");
        $stmt->bindParam(":n", $n);
        $stmt->execute();
        $products = $stmt->fetchAll();
        if ($onlyValid) {
            $products = array_filter($products, function ($product) {
                return $product["payment"] == null;
            });
        }
        return array_map(function ($product) use ($db) {
            return Product::rowToProduct($product, $db);
        }, $products);
    }

    public static function getAllProducts(PDO $db, bool $onlyValid = true): array {
        $stmt = $db->prepare("SELECT * FROM Product");
        $stmt->execute();
        $products = $stmt->fetchAll();
        if ($onlyValid) {
            $products = array_filter($products, function ($product) {
                return $product["payment"] == null;
            });
        }
        return array_map(function ($product) use ($db) {
            return Product::rowToProduct($product, $db);
        }, $products);
    }

    public function associateToPayment(PDO $db, int $paymentId): void {
        $stmt = $db->prepare("UPDATE Product SET payment = :paymentId WHERE id = :productId");
        $stmt->bindParam(":paymentId", $paymentId);
        $stmt->bindParam(":productId", $this->id);
        $stmt->execute();
        $this->payment = Payment::getPaymentById($db, (int)$paymentId);
    }
}
