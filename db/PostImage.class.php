<?php

declare(strict_types=1);

class PostImage {
    public Post $post;
    public Image $image;

    public function __construct(Post $post, Image $image){
        $this->post = $post;
        $this->image = $image;
    }

    public function upload(PDO $db){
        $stmt = $db->prepare("INSERT INTO PostImage (post, image) VALUES (:post, :image)");
        $stmt->bindParam(":post", $this->post->id);
        $stmt->bindParam(":image", $this->image->url);
        $stmt->execute();
    }
}