<?php

namespace SipalingNgoding\MVC\libs;

use JetBrains\PhpStorm\NoReturn;

class Helper{

    const FILTERS_SANITIZE = [
        'string' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'string[]' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'int' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_SCALAR
        ],
        'int[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'float' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'float[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'url' => FILTER_SANITIZE_URL,
    ];

    const DEFAULT_VALIDATION_ERRORS = [
        'required' => 'Please enter the %s',
        'email' => 'The %s is not a valid email address',
        'min' => 'The %s must have at least %s characters',
        'max' => 'The %s must have at most %s characters',
        'between' => 'The %s must have between %d and %d characters',
        'numeric' => 'The %s must numeric',
        'int' => 'The %s must integer',
        'float' => 'The %s must float',
        'alphanumeric' => 'The %s should have only letters and numbers',
        'secure' => 'The %s must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character',
        'url'=>'The %s must a url',
        'same'=>'The %s must be the same as the %s',
    ];
    public static function view(string $filename, array $data = []):void
    {
        extract($data);
        require_once  __DIR__."/../view/header.php";
        require_once __DIR__."/../view/".$filename.".php";
        require_once __DIR__."/../view/footer.php";
    }

    public static function array_trim(array $items):array
    {
        $result = [];
        foreach ($items as $key => $item)
        {
            if(is_string($item)) $result[$key] = trim($item);
            elseif (is_array($item)) $result[$key] = self::array_trim($item);
            else $result[$key] = $item;
        }
        return $result;
    }

    public static function sanitize(array $inputs, array $fields, array $FILTERS = self::FILTERS_SANITIZE, bool $trim = true ):array
    {
        $options = array_map(fn($field) => $FILTERS[$field], $fields);
        $data = filter_var_array($inputs, $options);
        return $trim ? self::array_trim($data) : $data;
    }

    public static function validate(array $inputs, array $fields,array &$errors = [], array $messages = self::DEFAULT_VALIDATION_ERRORS):array{
        foreach ($inputs as $key=>$input)
        {
            $rules = explode("|",$fields[$key]);
            $rules = array_map(fn($rule)=>trim($rule),$rules);
            foreach ($rules as $rule)
            {
                if($rule === 'continue') continue;
                if(preg_match("/\d/",$rule)){
                    preg_match_all('/\d+/',$rule,$matched);
                    $arguments = [$input,...$matched[0]];
                    preg_match_all('/[a-z]/',$rule,$matched);
                    $rule = implode("",$matched[0]);
                    $function = 'check_'.$rule;
                }elseif (preg_match("/\(/",$rule)){
                    preg_match_all('/\([a-zA-Z]+/',$rule,$matched);
                    $arguments  = [$input,$inputs[substr($matched[0][0],1)]];
                    $function = 'check_same';
                    $rule = 'same';
                } else{
                    $function = 'check_'.$rule;
                    $arguments = [$input];
                }
                $check = call_user_func_array(self::$function(...),$arguments);
                $rule === 'same' && $arguments = [$input,substr($matched[0][0],1)];
                if(!$check && !isset($errors[$key])) $errors[$key] = sprintf($messages[$rule],$key,...array_slice($arguments,1));
            }
        }
        return $errors;
    }

    static function filter(array $keys,array $fields,int $input_type = 0, array $messages = []):array
    {
        $errors = [];
        $data = [];
        foreach (self::DEFAULT_VALIDATION_ERRORS as $key=>$ERROR){
            if(!isset($messages[$key])) $messages[$key] = $ERROR;
        }

        foreach ($keys as $key){
            $is_exist = null;
            switch ($input_type){
                case 0:
                    $is_exist = isset($_POST[$key]);
                    break;
                case 1:
                    $is_exist = isset($_GET[$key]);
                    break;
            }
            if(!$is_exist){
                $errors[$key] = sprintf($messages['required'],$key);
                $data[$key] = "";
            }else{
                switch ($input_type){
                    case 0:
                        $data[$key] = $_POST[$key];
                        break;
                    case 1:
                        $data[$key] = $_GET[$key];
                        break;
                }
            }
        }
        $fields_sanitize = [];
        $fields_validate = [];
        foreach ($fields as $field=>$rules)
        {
            if(str_contains($rules,";")){
                [$fields_sanitize[$field],$fields_validate[$field]] = explode(";",$rules);
            }else{
                [$fields_sanitize[$field],$fields_validate[$field]] = [trim($rules),"continue"];
            }
        }
        $inputs = self::sanitize($data,$fields_sanitize);
        self::validate($inputs,$fields_validate,$errors,$messages);
        return [$inputs,$errors];
    }

    #[NoReturn] static function redirect(string $url): void
    {
        header("Location:$url");
        exit();
    }

    #[NoReturn] static function redirect_with_message($to, $message, $type = 'danger'):void
    {
        Flash::flash('flash_'.uniqid(),$message,$type);
        self::redirect($to);
    }

    static function create_session(array $data):void
    {
        foreach ($data as $key=>$value){
            $_SESSION[$key] = $value;
        }
    }

    #[NoReturn] static function redirect_with(string $url, array $data):void
    {
        self::create_session($data);
        self::redirect($url);
    }

    static function session_flash(...$keys):array
    {
        $data = [];
        foreach ($keys as $key){
            if(isset($_SESSION[$key])){
                $data[$key] = $_SESSION[$key];
                unset($_SESSION[$key]);
            }else{
                $data[$key] = [];
            }
        }
        return $data;
    }


    static function check_required($data):bool
    {
        return is_string($data) ? trim($data) !== '' : ($data !== '' && $data !== null) ;
    }

    static function check_int($data):bool
    {
        return filter_var($data,FILTER_VALIDATE_INT);
    }

    static function check_float($data):bool
    {
        return filter_var($data,FILTER_VALIDATE_FLOAT);
    }

    static function check_numeric($data):bool
    {
        return is_numeric($data);
    }

    static function  check_same($data1, $data2):bool
    {
        return $data1 === $data2;
    }


    static function check_email(string $email):bool
    {
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    static function check_min($data, $min):bool
    {
        return strlen($data) >= $min;
    }

    static function check_max($data,$max):bool
    {
        return strlen($data) <= $max;
    }

    static function check_between($data,$min,$max):bool
    {
        return (strlen($data) >= $min && strlen($data) <= $max);
    }

    static function check_secure(string $data, string $pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#"):bool
    {
        return preg_match($pattern,$data);
    }

    static function check_url($url):bool
    {
        return filter_var($url,FILTER_VALIDATE_URL);
    }
}
