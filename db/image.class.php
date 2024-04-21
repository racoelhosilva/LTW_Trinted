<?php

declare(strict_types=1);

class Image
{
    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}
