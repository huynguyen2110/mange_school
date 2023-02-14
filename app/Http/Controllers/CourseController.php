<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\MajorRequest;
use App\Models\Course;
use App\Repositories\Course\CourseInterface;
use Illuminate\Http\Request;

class CourseController extends BaseController
{

    private $course;

    public function __construct(CourseInterface $course){
        $this->course = $course;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Course::class);
        $users = $this->course->get($request);
        return view('course.index',[
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
        $this->authorize('create', Course::class);
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $course = $this->course->store($request);

        if (! $course) {
            $this->setFlash(__('Thêm khóa thất bại'), 'error');

            return redirect()->route('courses.create');
        }
        $this->setFlash(__('Thêm khóa thành công'));

        return redirect(route('courses.index'));
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
        $coursePolicy = Course::find($id);

        $this->authorize('update', $coursePolicy);

        $course = $this->course->getById($id);

        if (! $this->course->getById($id)) {
            $this->setFlash(__('Không tìm thấy khóa'), 'error');

            return redirect(route('courses.index'));
        }
        return view('course.edit',[
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
    public function update(CourseRequest $request, $id)
    {
        $coursePolicy = Course::find($id);

        $this->authorize('update', $coursePolicy);



        if ($this->course->update($request, $id)) {
            $this->setFlash(__('Cập nhật thông tin khóa thành công'));

            return redirect(route('courses.index'));
        }

        $this->setFlash(__('Cập nhật thông tin khóa thất bại thất bại'), 'error');

        return redirect(route('courses.edit', $id));
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
            'valid' => $this->course->checkName($data),
        ], StatusCode::OK);
    }
}
