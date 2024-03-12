<?php

namespace OneHRMS\trait;

trait ValidationTrait
{
    public function validateRequired($field, $value, &$errors)
    {
        if (empty($value)) {
            $errors[$field] = ucwords(str_replace("_", " ", $field)) . ' is required';
        }
    }

    public function validateEmail($field, $value, &$errors)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$field] = 'Invalid email format';
        }
    }
}
