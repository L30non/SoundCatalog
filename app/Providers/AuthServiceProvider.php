<?php

namespace App\Providers;
use App\Models\Sound;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Policies\SoundPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Sound::class => SoundPolicy::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Log::info('AuthServiceProvider boot method called');

        $this->registerPolicies();

        Gate::define('approve-sound',function($user,$sound){
            return $user->id === $sound->user_id || $user->isAdmin();
        });

        Gate::define('manage-sound',function($user,$sound){
            return $user->id === $sound->user_id || $user->isAdmin();
        });

    }
}
