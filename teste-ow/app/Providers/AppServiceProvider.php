<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('only_adults', function ($attribute, $value, $validator) {

            $dateBeginning = Carbon::createFromFormat('Y-m-d', $value); 
        
            $dateEnd = Carbon::now()->format('Y-m-d');
        
            return $dateBeginning->diffInYears($dateEnd) >= 18;

        }, 'only adults can create an account');
    }
}
