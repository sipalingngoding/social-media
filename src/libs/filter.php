<?php

function filter(array $keys,array $fields,int $input_type = 0, array $messages = []):array
{
    $errors = [];
    $data = [];
    foreach (DEFAULT_VALIDATION_ERRORS as $key=>$ERROR){
        if(!isset($messages[$key])) $messages[$key] = $ERROR;
    }

    foreach ($keys as $key){
        $is_exist = filter_has_var($input_type,$key);
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
    $inputs = sanitize($data,$fields_sanitize);
    validate($inputs,$fields_validate,$errors,$messages);
    return [$inputs,$errors];
}
