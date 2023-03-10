<?php

namespace App\Repositories\Teacher;

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

class TeacherRepository extends BaseController implements TeacherInterface
{
    private User $teacher;
    private Major $major;
    private Course $course;
    public function __construct(User $teacher, Major $major, Course $course)
    {
        $this->teacher = $teacher;
        $this->major = $major;
        $this->course = $course;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $teacherBuilder = $this->teacher
            ->with('majors')
            ->where('role', UserRole::Teacher)
            ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $teacherBuilder = $teacherBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('address', $request['search_input']));
            });
        }
        $teachers = $teacherBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($teachers)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $teachers = $teacherBuilder->paginate($newSizeLimit);
        }

        return $teachers;
    }

    public function getById($id)
    {
        return $this->teacher->where('uuid', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $teacher = new $this->teacher();
            $teacher->uuid = Base::generateUuid('tea');
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->password = Hash::make($request->password);
            $teacher->birthday = $request->birthday;
            $teacher->gender = $request->gender;
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->major_id = $request->major_id;
            $teacher->year_of_admission = date("Y");
            $teacher->role = UserRole::Teacher;

            if (! $teacher->save()) {
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

            $teacher = $this->teacher->where('uuid', $id)->first();
            $teacher->name = $request->name;
            $teacher->email = $request->email;
//            $teacher->password = Hash::make($request->password);
            $teacher->birthday = $request->birthday;
            $teacher->gender = $request->gender;
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->major_id = $request->major_id;


            if (! $teacher->save()) {
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
        $user = $this->teacher->where('uuid', $id)->first();
        if (! $user) {
            return false;
        }

        return $user->delete();
    }


    public function getMajors()
    {
        return $this->major->get();
    }

    public function getCourses()
    {
        return $this->course->get();

    }
}
