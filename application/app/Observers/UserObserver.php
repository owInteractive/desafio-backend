<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        Cache::forget('users');
        $transactions = Redis::keys(config('cache.prefix') . ':transactions*');
        if (!empty($transactions)) {
            Redis::del($transactions);
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function updated(User $user)
    {
        Cache::forget('users');
        $transactions = Redis::keys(config('cache.prefix') . ':transactions*');
        if (!empty($transactions)) {
            Redis::del($transactions);
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        Cache::forget('users');
        $transactions = Redis::keys(config('cache.prefix') . ':transactions*');
        if (!empty($transactions)) {
            Redis::del($transactions);
        }
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
