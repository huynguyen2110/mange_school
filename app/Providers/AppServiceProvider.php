<?php

namespace App\Providers;

use App\Repositories\Student\StudentInterface;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\Teacher\TeacherInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudentInterface::class, StudentRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(TeacherInterface::class, TeacherRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
