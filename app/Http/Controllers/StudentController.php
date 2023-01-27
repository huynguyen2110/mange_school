<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Requests\StudentRequest;
use App\Models\Course;
use App\Models\User;
use App\Repositories\Course\CourseInterface;
use App\Repositories\Major\MajorInterface;
use App\Repositories\Student\StudentInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends BaseController
{
   private $student;

    public function __construct(StudentInterface $student){
        $this->student = $student;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->student->get($request);

        return view('student.index',[
            'users' => $users,
            'newSizeLimit' => $this->newListLimit($request),
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $major = $this->student->getMajors();
        $course = $this->student->getCourses();

        return view('student.create',[
            'major' => $major,
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $student = $this->student->store($request);

        if (! $student) {
            $this->setFlash(__('Thêm sinh viên thất bại'), 'error');

            return redirect()->route('students.create');
        }
        $this->setFlash(__('Thêm sinh viên thành công'));

        return redirect(route('students.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $student = $this->student->getById($id);
        $major = $this->student->getMajors();
        $course = $this->student->getCourses();

        if (! $this->student->getById($id)) {
            $this->setFlash(__('Không tìm thấy sinh viên'), 'error');

            return redirect(route('students.index'));
        }
        return view('student.edit',[
            'student' => $student,
            'major' => $major,
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        if ($this->student->update($request, $id)) {
            $this->setFlash(__('Cập nhật thông tin sinh viên thành công'));

            return redirect(route('students.index'));
        }

        $this->setFlash(__('Cập nhật thông tin sinh viên thất bại'), 'error');

        return redirect(route('students.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->student->destroy($id)) {
            return response()->json([
                'message' => 'Đã xóa thành công',
            ], StatusCode::OK);
        }

        return response()->json([
            'message' => 'Có lỗi xảy ra',
        ], StatusCode::INTERNAL_ERR);
    }

    public function checkMail(Request $request)
    {
        $data = $request->all();
        $data['id'] = $request->id;

        return response()->json([
            'valid' => $this->student->checkEmail($data),
        ], StatusCode::OK);
    }

    public function checkPhone(Request $request)
    {
        $data = $request->all();
        $data['id'] = $request->id;

        return response()->json([
            'valid' => $this->student->checkPhone($data),
        ], StatusCode::OK);
    }
}
