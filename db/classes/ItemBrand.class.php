<?php

declare(strict_types=1);

class ItemBrand {
    public Item $item;
    public Brand $brand;

    public function __construct(Item $item, Brand $brand){
        $this->item = $item;
        $this->brand = $brand;
    }

    public function upload(PDO $db){
        $stmt = $db->prepare("INSERT INTO ItemBrand (item, brand) VALUE (:item, :brand)");
        $stmt->bindParam(":item", $this->item->id);
        $stmt->bindParam(":brand", $this->brand->name);
    }
}