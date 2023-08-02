<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class tipoOperacao implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tipos = ['DEBITO','CREDITO','ESTORNO'];
        if (!in_array(strtoupper($value),$tipos)) {
           $fail($value.' not permitted.');
        }
    }
}
