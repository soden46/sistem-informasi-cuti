<?php

namespace App\Providers;

use App\Models\Employee;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('manajer divisi', function (Employee $user) {
            return $user->hak_akses == 'manajer divisi';
        });

        Gate::define('hrd', function (Employee $user) {
            return $user->hak_akses == 'hrd';
        });

        Gate::define('karyawan', function (Employee $user) {
            return $user->hak_akses == 'karyawan';
        });
    }
}
