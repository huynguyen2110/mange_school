<?php

namespace App\Repositories\Course;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Major;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\Teacher\TeacherInterface;
use App\Repositories\User\UserInterface;
use App\Utils\Base;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Paginator;

class CourseRepository extends BaseController implements CourseInterface
{
    private Course $course;
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $courseBuilder = $this->course
            ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $majorBuilder = $courseBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
            });
        }
        $courses = $courseBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($courses)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $courses = $courseBuilder->paginate($newSizeLimit);
        }

        return $courses;
    }

    public function getById($id)
    {
        return $this->course->where('id', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $course = new $this->course();
            $course->name = $request->name;
            $course->founded_year = date("Y");

            if (! $course->save()) {
                DB::rollBack();

                return false;
            }
            DB::commit();
            return true;
        }
        catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return false;
        }

    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();

            $course = $this->course->where('id', $id)->first();
            $course->name = $request->name;


            if (! $course->save()) {
                DB::rollBack();

                return false;
            }
            DB::commit();
            return true;
        }
        catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id)
    {

    }

    public function checkName($request)
    {
        if (isset($request['value']) != '') {
            return ! $this->course->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('id', '!=', $request['id']);
                }
                $query->where(['name' => $request['value']]);
            })->exists();
        }
        if (isset($request['name']) != '') {
            return $this->course->where('name', $request['name'])->exists();
        }

        return true;
    }
}
