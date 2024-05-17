<?php

include_once(__DIR__ . "/Product.class.php");

class Payment {
    public int $id;
    public float $subtotal;
    public string $shipping;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $phone;
    public string $address;
    public string $zipCode;
    public string $town;
    public string $country;
    public int $paymentDatetime;

    public function __construct(float $subtotal, string $shipping, string $firstName, string $lastName, string $email, string $phone, string $address, string $zipCode, string $town, string $country, int $paymentDatetime) {
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
            );
            $result->id = $id;
            return $result;
        }
    }
}