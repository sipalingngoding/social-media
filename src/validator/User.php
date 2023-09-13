<?php

namespace SipalingNgoding\MVC\validator;

use SipalingNgoding\MVC\libs\Helper;

class User
{
    /**
     * @throws \Exception
     */
    public static function validateRegisterInput():array
    {
        [$inputs,$errors] = Helper::filter(['email','full_name','address','password','confPassword','agree'],['email'=>'email;required | email','full_name'=>'string;required | between(8,20)','address'=>'string ; required | min(5)','password'=>'string;required | secure','confPassword'=>'string;required | same(password)','agree'=>'string ; required']);
        return [$inputs,$errors];
    }

    public static function validateLoginInput():array
    {
        [$inputs,$errors] = Helper::filter(['email','password',],['email'=>'email;required | email','password'=>'string;required']);
        return [$inputs,$errors];
    }
}
