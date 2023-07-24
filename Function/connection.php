<?php

namespace Function;

function connection():\PDO
{
    return new \PDO("mysql:host=localhost;dbname=belajarphp",'root','');
}
