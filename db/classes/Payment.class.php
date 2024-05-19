<?php

require_once __DIR__ . '/../../framework/Autoload.php';

class Payment {
    private int $id;
    private float $subtotal;
    private string $shipping;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $address;
    private string $zipCode;
    private string $town;
    private string $country;
    private int $paymentDatetime;
    private User $buyer;

    public function __construct(float $subtotal, string $shipping, string $firstName, string $lastName, string $email, string $phone, string $address, string $zipCode, string $town, string $country, int $paymentDatetime, User $buyer) {
        $this->subtotal = $subtotal;
        $this->shipping = $shipping;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->paymentDatetime = $paymentDatetime;
        $this->buyer = $buyer;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getSubtotal(): float {
        return $this->subtotal;
    }

    public function getShipping(): string {
        return $this->shipping;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getZipCode(): string {
        return $this->zipCode;
    }

    public function getTown(): string {
        return $this->town;
    }

    public function getCountry(): string {
        return $this->country;
    }

    public function getPaymentDatetime(): int {
        return $this->paymentDatetime;
    }

    public function upload(PDO $db): void {
        $stmt = $db->prepare("INSERT INTO Payment (subtotal, shipping, firstName, lastName, email, phone, address, zipCode, town, country, paymentDatetime) VALUES (:subtotal, :shipping, :firstName, :lastName, :email, :phone, :address, :zipCode, :town, :country, :paymentDatetime)");
        $stmt->bindParam(":subtotal", $this->subtotal);
        $stmt->bindParam(":shipping", $this->shipping);
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":zipCode", $this->zipCode);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":paymentDatetime", $this->paymentDatetime);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getAssociatedProductsFromSeller(PDO $db, int $sellerId): array {
        $stmt = $db->prepare("SELECT id FROM Product WHERE payment = :payment AND seller = :seller");
        $stmt->bindParam(":payment", $this->id);
        $stmt->bindParam(":seller", $sellerId);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return array_map(function ($product) use ($db) {
            return Product::getProductByID($db, $product["id"], false);
        }, $products);
    }

    public static function getPaymentById(PDO $db, int $id): ?Payment {
        $stmt = $db->prepare("SELECT * FROM Payment WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $payment = $stmt->fetch();
        if (!isset($payment["id"]))
            return null;
        else {
            $result = new Payment(
                $payment["subtotal"],
                $payment["shipping"],
                $payment["firstName"],
                $payment["lastName"],
                $payment["email"],
                $payment["phone"],
                $payment["address"],
                $payment["zipCode"],
                $payment["town"],
                $payment["country"],
                $payment["paymentDatetime"],
                User::getUserByID($db, (int)$payment["buyer"]),
            );
            $result->id = $id;
            return $result;
        }
    }
}