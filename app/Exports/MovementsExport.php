<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Movement;
use App\Models\User;

class MovementsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
    public function __construct($request)
    {
        $this->request = $request; 
    }

    public function view(): View
    { 
        if(!empty($this->request->user())){
            $user = $this->request->user();
        }else{
            $user = User::findorFail($this->request->user_id);
        } 

        return view('exports', [
            'movements' => Movement::filter($this->request,$user->id),
            'user'=>$user
        ]); 
    }
}
