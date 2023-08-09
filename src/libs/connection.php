<?php

function connection():PDO
{
    return new PDO(sprintf("mysql:host=%s;dbname=%s",DB_HOST,DB_NAME),DB_USER,DB_PASSWORD);
}
