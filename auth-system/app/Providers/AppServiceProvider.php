<?php

namespace App\Providers;

use App\Repositories\BlogRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\BlogReadRepository;
use App\Repositories\TwoFactorRepository;
use App\Contracts\BlogRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Contracts\BlogReadRepositoryInterface;
use App\Contracts\TwoFactorRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * This method is intended for binding interfaces to implementations
     * and for registering services into the container. Keeping all bindings
     * explicit and centralized makes dependencies predictable and testable.
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * Bootstrap application services.
     *
     * Perform any actions that need to happen once all services are registered.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Bind repository interfaces to their concrete implementations.
     *
     * Following the Dependency Inversion Principle (DIP),
     * all higher-level components depend on abstractions, not concretions.
     */
    protected function registerRepositories(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TwoFactorRepositoryInterface::class, TwoFactorRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(BlogReadRepositoryInterface::class, BlogReadRepository::class);

    }
}
