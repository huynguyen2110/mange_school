<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Requests\ClassRequest;
use App\Models\ClassStudent;
use App\Repositories\Classes\ClassInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends BaseController
{
    private $class;

    public function __construct(ClassInterface $class){
        $this->class = $class;
    }


    public function index(Request $request)
    {

        $users = $this->class->get($request);
        return view('class.index',[
            'users' => $users,
            'newSizeLimit' => $this->newListLimit($request),
            'request' => $request,
            'currentUser' => Auth::user()->uuid,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subject = $this->class->getSubjects();
        $teacher = $this->class->getTeachers();

        return view('class.create',[
            'teacher' => $teacher,
            'subject' => $subject,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequest $request)
    {
        $class = $this->class->store($request);

        if (! $class) {
            $this->setFlash(__('Thêm lớp thất bại'), 'error');

            return redirect()->route('classes.create');
        }
        $this->setFlash(__('Thêm lớp thành công'));

        return redirect(route('classes.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = $this->class->getSubjects();
        $teacher = $this->class->getTeachers();
        $class = $this->class->getById($id);

        if (! $this->class->getById($id)) {
            $this->setFlash(__('Không tìm thấy lớp'), 'error');

            return redirect(route('classes.index'));
        }
        return view('class.edit',[
            'subject' => $subject,
            'class' => $class,
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRequest $request, $id)
    {
        if ($this->class->update($request, $id)) {
            $this->setFlash(__('Cập nhật thông tin lớp thành công'));

            return redirect(route('classes.index'));
        }

        $this->setFlash(__('Cập nhật thông tin lớp thất bại thất bại'), 'error');

        return redirect(route('classes.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkName(Request $request)
    {
        $data = $request->all();
        $data['id'] = $request->id;

        return response()->json([
            'valid' => $this->class->checkName($data),
        ], StatusCode::OK);
    }

    public function registerClass(Request $request)
    {
        if ($this->class->storeRegisterClass($request)) {
            return response()->json([
                'message' => 'Đã đăng kí thành công',
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'Có lỗi xảy ra',
        ], StatusCode::INTERNAL_ERR);
    }

    public function cancelClass(Request $request)
    {
        if ($this->class->CancelClass($request)) {
            return response()->json([
                'message' => 'Hủy đăng kí thành công',
            ], StatusCode::OK);
        }
        return response()->json([
            'message' => 'Có lỗi xảy ra',
        ], StatusCode::INTERNAL_ERR);
    }
}
