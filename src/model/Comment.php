<?php

namespace SipalingNgoding\MVC\model;

class Comment
{
    public function __construct(
        public int $id,
        public int $userId,
        public int $photoId,
        public string $comment,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }
}
