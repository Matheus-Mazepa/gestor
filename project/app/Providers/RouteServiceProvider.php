<?php

namespace App\Providers;

use App\Enums\UserRolesEnum;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->mapDefaultWebRoutes();

        $this->mapAuthenticatedWebRoutes();
        $this->mapUnauthenticatedWebRoutes();
        $this->mapPaginationRoutes();
        $this->mapAjaxRoutes();

        $this->mapAdminRoutes();
        $this->mapClientRoutes();
    }

    protected function mapDefaultWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapAuthenticatedWebRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web/shared/authenticated.php'));
    }

    protected function mapUnauthenticatedWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/shared/unauthenticated.php'));
    }

    protected function mapPaginationRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('pagination')
            ->group(base_path('routes/web/shared/pagination.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('ajax')
            ->group(base_path('routes/web/shared/ajax.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::namespace($this->namespace . '\Admin')
            ->middleware(['web', 'auth', 'user-type:' . UserRolesEnum::ADMIN])
            ->group(function () {

                Route::name('ajax.admin.')
                    ->prefix('ajax/admin')
                    ->group(base_path('routes/web/admin/ajax.php'));

                Route::name('admin.')
                    ->prefix('admin')
                    ->group(base_path('routes/web/admin/authenticated.php'));

                Route::name('admin.')
                    ->prefix('pagination/admin')
                    ->group(base_path('routes/web/admin/pagination.php'));
            });
    }

    protected function mapClientRoutes()
    {
        Route::namespace($this->namespace . '\Client')
            ->middleware(['web', 'auth', 'user-type:' . UserRolesEnum::CLIENT])
            ->group(function () {

                Route::name('ajax.client.')
                    ->prefix('ajax/client')
                    ->group(base_path('routes/web/client/ajax.php'));

                Route::name('client.')
                    ->prefix('client')
                    ->group(base_path('routes/web/client/authenticated.php'));

                Route::name('client.')
                    ->prefix('pagination/client')
                    ->group(base_path('routes/web/client/pagination.php'));
            });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $this->mapApiV1Routes();
    }

    protected function mapApiV1Routes()
    {
        $namespace = $this->namespace . '\Api\v1';

        Route::prefix('api/v1')
            ->middleware('api')
            ->middleware('auth:api')
            ->namespace($namespace)
            ->group(base_path('routes/api/v1/authenticated.php'));

        Route::prefix('api/v1')
            ->middleware('api')
            ->middleware('auth:api')
            ->namespace($namespace)
            ->group(base_path('routes/api/v1/unauthenticated.php'));
    }
}
