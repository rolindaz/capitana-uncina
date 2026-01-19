<?php

namespace App\Providers;

use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('project', function (string $value) {
            if (ctype_digit($value)) {
                return Project::query()->findOrFail((int) $value);
            }

            $locale = app()->getLocale();

            return Project::query()
                ->whereHas('translation', function ($query) use ($value, $locale) {
                    $query->where('slug', $value)->where('locale', $locale);
                })
                ->firstOrFail();
        });
    }
}
