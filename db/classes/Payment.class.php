<?php

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
    public string $city;
    public string $country;
    public int $paymentDatetime;

    public function __construct(float $subtotal, string $shipping, string $firstName, string $lastName, string $email, string $phone, string $address, string $zipCode, string $city, string $country, int $paymentDatetime) {
        $this->subtotal = $subtotal;
        $this->shipping = $shipping;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->country = $country;
        $this->paymentDatetime = $paymentDatetime;
    }

    public function upload(PDO $db): void {
        $stmt = $db->prepare("INSERT INTO Payment (subtotal, shipping, firstName, lastName, email, phone, address, zipCode, city, country, paymentDatetime) VALUES (:subtotal, :shipping, :firstName, :lastName, :email, :phone, :address, :zipCode, :city, :country, :paymentDatetime)");
        $stmt->bindParam(":subtotal", $this->subtotal);
        $stmt->bindParam(":shipping", $this->shipping);
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":zipCode", $this->zipCode);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":paymentDatetime", $this->paymentDatetime);
        $stmt->execute();
        $stmt = $db->prepare("SELECT last_insert_rowid()");
        $stmt->execute();
        $id = $stmt->fetch();
        $this->id = $id[0];
    }

    public function getPosts(PDO $db): array {
        $stmt = $db->prepare("SELECT id FROM Post WHERE payment = :payment");
        $stmt->bindParam(":payment", $this->id);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return array_map(function ($post) use ($db) {
            return Post::getPostByID($db, $post["id"]);
        }, $posts);
    }
}