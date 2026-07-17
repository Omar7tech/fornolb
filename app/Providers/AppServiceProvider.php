<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\ExceptionResponse;
use Inertia\Inertia;

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
        $this->configureDefaults();
        $this->configureErrorPages();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Route storefront errors to the branded error page.
     *
     * The admin panel is left alone so Filament keeps its own handling, and a
     * 500 stays with the framework's error page while debugging, where the
     * stack trace is the whole point.
     */
    protected function configureErrorPages(): void
    {
        Inertia::handleExceptionsUsing(function (ExceptionResponse $response): ExceptionResponse {
            $status = $response->statusCode();

            $isStorefrontError = ! $response->request->is('admin', 'admin/*')
                && (in_array($status, [403, 404, 419, 429, 503], true)
                    || ($status >= 500 && ! config('app.debug')));

            if (! $isStorefrontError) {
                return $response;
            }

            return $response
                ->render('error', ['status' => $status])
                ->withSharedData();
        });
    }
}
