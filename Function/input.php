<?php

namespace Function;

function input(string $information):string
{
    echo "$information: ";
    return trim(fgets(STDIN));
}


