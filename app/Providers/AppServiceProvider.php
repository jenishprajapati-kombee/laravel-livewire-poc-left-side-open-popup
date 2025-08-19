<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function register(): void
    {
        if (App::environment(['local'])) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->bind(\Illuminate\Contracts\Debug\ExceptionHandler::class, \App\Exceptions\Handler::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Passport::enablePasswordGrant();

        $permissions = [
'view-role','show-role','add-role','edit-role','delete-role','bulkDelete-role','import-role','export-role','role-imports','view-country','show-country','add-country','edit-country','delete-country','bulkDelete-country','import-country','export-country','country-imports','view-state','show-state','add-state','edit-state','delete-state','bulkDelete-state','import-state','export-state','state-imports','view-city','show-city','add-city','edit-city','delete-city','bulkDelete-city','import-city','export-city','city-imports','view-user','show-user','add-user','edit-user','delete-user','bulkDelete-user','import-user','export-user','user-imports','view-brand','show-brand','add-brand','edit-brand','delete-brand','bulkDelete-brand','import-brand','export-brand','brand-imports','view-brand-detail','show-brand-detail','add-brand-detail','edit-brand-detail','delete-brand-detail','bulkDelete-brand-detail','import-brand-detail','export-brand-detail','brand-detail-imports'
];

        foreach ($permissions as $permission) {
            Gate::define($permission, function ($user) use ($permission) {
                return $user->hasPermission($permission, $user->role_id);
            });
        }

        $this->bootAuth();
    }

    public function bootAuth()
    {
        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(now()->addDays(7));
    }
}
