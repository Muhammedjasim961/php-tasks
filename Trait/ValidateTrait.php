<?php

namespace OneHRMS\Trait;


trait ValidateTrait
{

    public function validateRequired($field, $value, &$errors)
    {

        if (empty($value)) {
            $errors[$field] = ucwords(str_replace("_", " ", $field)) . ' is Required';
        }
    }
    
    public function validateEmail($field, $value, $errors)
    {

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$field] = 'Invalid Email Format';
        }
    }
}
