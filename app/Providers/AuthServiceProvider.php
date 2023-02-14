<?php

namespace App\Providers;

use App\Models\Classes;
use App\Models\Course;
use App\Models\Major;
use App\Models\Subject;
use App\Models\User;
use App\Policies\ClassPolicy;
use App\Policies\CoursePolicy;
use App\Policies\MajorPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Major::class => MajorPolicy::class,
        Course::class => CoursePolicy::class,
        Subject::class => SubjectPolicy::class,
        User::class => UserPolicy::class,
        Classes::class => ClassPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
