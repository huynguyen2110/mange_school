<?php

namespace App\Repositories\Classes;

use App\Enums\UserRole;
use App\Models\Classes;
use App\Models\ClassStudent;
use App\Models\Subject;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Paginator;

class ClassRepository extends BaseController implements ClassInterface
{
    private Classes $class;
    private Subject $subject;
    private User $teacher;
    private ClassStudent $classStudent;


    public function __construct(Classes $class, Subject $subject, User $teacher, ClassStudent $classStudent)
    {
        $this->class = $class;
        $this->subject = $subject;
        $this->teacher = $teacher;
        $this->classStudent = $classStudent;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $classBuilder = $this->class
            ->with(['teachers','subjects'])
            ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $classBuilder = $classBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
            });
        }
        $classes = $classBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($classes)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $classes = $classBuilder->paginate($newSizeLimit);
        }

        return $classes;
    }

    public function getById($id)
    {
        return $this->class->where('id', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $class = new $this->class();
            $class->name = $request->name;
            $class->subject_id = $request->subject_id;
            $class->teacher_id = $request->teacher_id;

            if (! $class->save()) {
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

            $class = $this->class->where('id', $id)->first();
            $class->name = $request->name;
            $class->subject_id = $request->subject_id;
            $class->teacher_id = $request->teacher_id;


            if (! $class->save()) {
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
        // TODO: Implement destroy() method.
    }

    public function getSubjects()
    {
        return $this->subject->get();
    }

    public function getTeachers()
    {
        return $this->teacher
            ->where('role', UserRole::Teacher)
            ->get();
    }

    public function checkName($request)
    {
        if (isset($request['value']) != '') {
            return ! $this->class->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('id', '!=', $request['id']);
                }
                $query->where(['name' => $request['value']]);
            })->exists();
        }
        if (isset($request['name']) != '') {
            return $this->class->where('name', $request['name'])->exists();
        }

        return true;
    }

    public function storeRegisterClass($request)
    {
        try {
            DB::beginTransaction();

            $classStudent = new $this->classStudent();
            $classStudent->student_id = $request->student_id;
            $classStudent->class_id = $request->class_id;

            if (! $classStudent->save()) {
                DB::rollBack();

                return false;
            }
            DB::commit();
            return true;
        }
        catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function cancelClass($request)
    {
        $class = $this->classStudent
            ->where('student_id', $request->student_id)
            ->where('class_id', $request->class_id)
            ->first();
        if (! $class) {
            return false;
        }

        return $class->delete();
    }
}
