<?php

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


function validate(array $inputs, array $fields, array &$errors = []):array{
    foreach ($inputs as $key=>$input)
    {
        $rules = explode("|",$fields[$key]);
        $rules = array_map(fn($rule)=>trim($rule),$rules);
        foreach ($rules as $rule)
        {
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
            $check = call_user_func_array($function,$arguments);
            $rule === 'same' && $arguments = [$input,substr($matched[0][0],1)];
            if(!$check && !isset($errors[$key])) $errors[$key] = sprintf(DEFAULT_VALIDATION_ERRORS[$rule],$key,...array_slice($arguments,1));
        }
    }
    return $errors;
}

function check_required($data):bool
{
    return is_string($data) ? trim($data) !== '' : ($data !== '' && $data !== null) ;
}

function check_int($data):bool
{
    return filter_var($data,FILTER_VALIDATE_INT);
}

function check_float($data):bool
{
    return filter_var($data,FILTER_VALIDATE_FLOAT);
}

function check_numeric($data):bool
{
    return is_numeric($data);
}

function  check_same($data1, $data2):bool
{
    return $data1 === $data2;
}


function check_email(string $email):bool
{
    return filter_var($email,FILTER_VALIDATE_EMAIL);
}

function check_min($data, $min):bool
{
    return strlen($data) >= $min;
}

function check_max($data,$max):bool
{
    return strlen($data) <= $max;
}

function check_between($data,$min,$max):bool
{
    return (strlen($data) >= $min && strlen($data) <= $max);
}

function check_secure(string $data, string $pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#"):bool
{
    return preg_match($pattern,$data);
}

function check_url($url):bool
{
    return filter_var($url,FILTER_VALIDATE_URL);
}
