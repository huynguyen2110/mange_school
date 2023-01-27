<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Repositories\Subject\SubjectInterface;
use Illuminate\Http\Request;

class SubjectController extends BaseController
{
    private $subject;

    public function __construct(SubjectInterface $subject){
        $this->subject = $subject;
    }


    public function index(Request $request)
    {
        $users = $this->subject->get($request);
        return view('subject.index',[
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
        $major = $this->subject->getMajors();

        return view('subject.create',[
            'major' => $major,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject = $this->subject->store($request);

        if (! $subject) {
            $this->setFlash(__('Thêm môn thất bại'), 'error');

            return redirect()->route('subjects.create');
        }
        $this->setFlash(__('Thêm môn thành công'));

        return redirect(route('subjects.index'));
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
        $subject = $this->subject->getById($id);
        $major = $this->subject->getMajors();

        if (! $this->subject->getById($id)) {
            $this->setFlash(__('Không tìm thấy môn'), 'error');

            return redirect(route('subjects.index'));
        }
        return view('subject.edit',[
            'subject' => $subject,
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
    public function update(Request $request, $id)
    {
        if ($this->subject->update($request, $id)) {
            $this->setFlash(__('Cập nhật thông tin môn thành công'));

            return redirect(route('subjects.index'));
        }

        $this->setFlash(__('Cập nhật thông tin môn thất bại thất bại'), 'error');

        return redirect(route('subjects.edit', $id));
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
            'valid' => $this->subject->checkName($data),
        ], StatusCode::OK);
    }
}
