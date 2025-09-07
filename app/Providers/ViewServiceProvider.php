<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Antrian;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.navbars.guest.sidebar', function ($view) {
            $user = Auth::user();

            $antrians = collect();
            $totalAntrian = 0;

            if ($user) {
                $antrians = Antrian::where('user_id', $user->id)
                    ->where('waktu_datang', '>=', Carbon::today())
                    ->with('user')
                    ->orderBy('waktu_datang', 'asc')
                    ->get();

                $totalAntrian = $antrians->count();
            }

            $view->with([
                'antrians' => $antrians,
                'totalAntrian' => $totalAntrian,
            ]);
        });
    }
}
