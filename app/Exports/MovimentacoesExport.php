<?php

namespace App\Exports;

use App\Http\Resources\MovimentacaoResource;
use App\Models\Movimentacao;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovimentacoesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $movimentacao=Movimentacao::all();
        if (request()->filtro) {
            if (request()->filtro=='ultimos_30dias') {
                $movimentacao=Movimentacao::where('created_at', '>', now()->subDays(30)->endOfDay())->get();
            }elseif(str_contains(request()->filtro,'/')){
                $array = explode('/',request()->filtro);
                $movimentacao = Movimentacao::whereMonth('created_at', '=', $array[0])
                                            ->whereYear('created_at', '=', $array[1])
                                            ->get();
            }
        }
        return $movimentacao;
    }
}
