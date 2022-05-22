<?php

namespace App\helpers;

use Carbon\Carbon;

class TransitionsHelpers 
{
    public function transformDataToCSV($data)
    {
        $data = $data->map(function ($item) {
            $attributes = collect($item)->except('updated_at');
            $attributes['created_at'] = Carbon::parse($attributes['created_at'])->format('d/m/Y');
            $attributes['email'] = $item['user']['email'];
            return $attributes->except('user');
        });
        
        return $data->toArray();
    }
}
