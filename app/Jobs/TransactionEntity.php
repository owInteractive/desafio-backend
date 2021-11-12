<?php

namespace App\Jobs;

class TransactionEntity
{
    public $value;
    public $name;

    public function __construct($value, $name)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
