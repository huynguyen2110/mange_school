<?php

namespace App\Providers;

use App\Repositories\Course\CourseInterface;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Major\MajorInterface;
use App\Repositories\Major\MajorRepository;
use App\Repositories\Student\StudentInterface;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectInterface;
use App\Repositories\Subject\SubjectRepository;
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
        $this->app->bind(MajorInterface::class, MajorRepository::class);
        $this->app->bind(CourseInterface::class, CourseRepository::class);
        $this->app->bind(SubjectInterface::class, SubjectRepository::class);
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
