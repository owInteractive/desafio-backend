<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exceptions\InvalidDataException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validator(array $data, array $validations)
    {
        $validator = Validator::make($data, $validations);
        if ($validator->fails()) {
            throw new InvalidDataException($validator->errors()->all());
        }
    }
}
