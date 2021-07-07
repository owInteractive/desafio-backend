<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Movement;
use Carbon\Carbon;

class Moves30DayExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Movement::all()->where('created_at', '>', Carbon::now()->subDays(30));
    }
}
