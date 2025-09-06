<?php

function error_class(array $errors, string $field): string
{
    return isset($errors[$field]) ? 'form-input__input--error' : '';
}