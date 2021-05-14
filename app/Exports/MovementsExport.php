<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Movement;

class MovementsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    public function __construct(int $perPage, int $page)
    {
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function collection()
    { 
        return Movement::orderBy('id', 'DESC')->limit($this->perPage)->offset(($this->page - 1) * $this->perPage)->get();
    }
}
