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
            ,
            [
                \App\Repositories\Inn\InnRepositoryInterface::class,
                \App\Repositories\Inn\InnRepository::class,
            ],
            [
                \App\Repositories\Room\RoomRepositoryInterface::class,
                \App\Repositories\Room\RoomRepository::class
            ],
            [
                \App\Repositories\RoomComment\RoomCommentRepositoryInterface::class,
                \App\Repositories\RoomComment\RoomCommentRepository::class
            ],
            [
                \App\Repositories\RoomFavorite\RoomFavoriteRepositoryInterface::class,
                \App\Repositories\RoomFavorite\RoomFavoriteRepository::class
            ],
            [
                \App\Repositories\InnFeature\InnFeatureRepositoryInterface::class,
                \App\Repositories\InnFeature\InnFeatureRepository::class
            ],
            [
                \App\Repositories\InnImage\InnImageRepositoryInterface::class,
                \App\Repositories\InnImage\InnImageRepository::class
            ]
        ];

        foreach ($repositories as $repo) {
            $this->app->singleton($repo[0], $repo[1]);
        }
    }
}
