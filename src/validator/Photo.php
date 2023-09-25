<?php

namespace SipalingNgoding\MVC\validator;

use SipalingNgoding\MVC\libs\Helper;

class Photo
{
    public static function validateInsertPhoto():array
    {
        [$inputs,$errors]= Helper::filter(['title','description'],['title'=>'string;required | between(5,20)','description'=>'string;required | min(10)']);

        return [$inputs,$errors];
    }

}
