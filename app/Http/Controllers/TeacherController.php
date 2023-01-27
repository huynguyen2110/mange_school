<?php

namespace App\Http\Controllers;


use App\Enums\StatusCode;
use App\Http\Requests\TeacherRequest;
use App\Repositories\Teacher\TeacherInterface;
use Illuminate\Http\Request;

class TeacherController extends BaseController
{

    private $teacher;

    public function __construct(TeacherInterface $teacher){
        $this->teacher = $teacher;
    }

    public function index(Request $request)
    {
        $users = $this->teacher->get($request);
        return view('teacher.index',[
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
        $major = $this->teacher->getMajors();


        return view('teacher.create',[
            'major' => $major,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        $teacher = $this->teacher->store($request);

        if (! $teacher) {
            $this->setFlash(__('Thêm giảng viên viên thất bại'), 'error');

            return redirect()->route('teachers.create');
        }
        $this->setFlash(__('Thêm giảng viên thành công'));

        return redirect(route('teachers.index'));
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
        $teacher = $this->teacher->getById($id);
        $major = $this->teacher->getMajors();

        if (! $this->teacher->getById($id)) {
            $this->setFlash(__('Không tìm thấy giảng viên'), 'error');

            return redirect(route('teachers.index'));
        }
        return view('teacher.edit',[
            'teacher' => $teacher,
            'major' => $major,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, $id)
    {
        if ($this->teacher->update($request, $id)) {
            $this->setFlash(__('Cập nhật thông tin giảng viên thành công'));

            return redirect(route('teachers.index'));
        }

        $this->setFlash(__('Cập nhật thông tin giảng viên thất bại'), 'error');

        return redirect(route('teachers.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->teacher->destroy($id)) {
            return response()->json([
                'message' => 'Đã xóa thành công',
            ], StatusCode::OK);
        }

        return response()->json([
            'message' => 'Có lỗi xảy ra',
        ], StatusCode::INTERNAL_ERR);
    }
}
