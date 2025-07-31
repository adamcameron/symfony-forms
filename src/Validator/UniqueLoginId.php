<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class UniqueLoginId extends Constraint
{
    public string $message = 'This login ID is already in use.';
}
