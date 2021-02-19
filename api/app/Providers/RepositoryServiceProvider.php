<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $repositories = [
            [
                \App\Repositories\Tenant\TenantRepositoryInterface::class,
                \App\Repositories\Tenant\TenantRepository::class
            ],
            [
                \App\Repositories\Owner\OwnerRepositoryInterface::class,
                \App\Repositories\Owner\OwnerRepository::class
            ],
            [
                \App\Repositories\OwnerContact\OwnerContactRepositoryInterface::class,
                \App\Repositories\OwnerContact\OwnerContactRepository::class
            ]
        ];

        foreach ($repositories as $repo) {
            $this->app->singleton($repo[0], $repo[1]);
        }
    }
}
