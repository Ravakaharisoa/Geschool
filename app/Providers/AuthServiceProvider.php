<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("isDirecteur",function(User $user){
            return $user->hasRole("Directeur");
        });

        Gate::define("isResponsable",function(User $user){
            return $user->hasRole("Responsable");
        });

        Gate::define("isProfesseur",function(User $user){
            return $user->hasRole("Professeur");
        });

        Gate::define("isEtudiant",function(User $user){
            return $user->hasRole("Etudiant");
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Vérifié adresse email')
                ->view('auth.emails_verify.email',
                [
                    'action' => $url,
                    'user' => $notifiable,
                ]);
        });
    }
}
