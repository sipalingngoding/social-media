<?php

namespace SipalingNgoding\MVC\model;

class Photo
{
    public function __construct(
        public string $title,
        public string $description,
        public string $image,
        public int $userId,
        public string $createdAt,
        public string $updatedAt,
        public int $id = 0,
    )
    {
    }
}
