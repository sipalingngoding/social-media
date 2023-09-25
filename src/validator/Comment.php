<?php

namespace SipalingNgoding\MVC\validator;

use SipalingNgoding\MVC\libs\Helper;

class Comment
{
    public static function validateInsertComment():array
    {
        [$inputs, $errors] = Helper::filter(['comment'],['comment'=>'string;required']);

        return [$inputs,$errors];
    }
}
