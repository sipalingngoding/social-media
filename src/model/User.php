<?php

namespace SipalingNgoding\MVC\model;

class User
{
    public function __construct(
        public string $email,public string $password, public string $full_name, public string $address,
    ){}
}
