<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Requests\MajorRequest;
use App\Models\Major;
use App\Repositories\Major\MajorInterface;
use Illuminate\Http\Request;

class MajorController extends BaseController
{
    private $major;

    public function __construct(MajorInterface $major){
        $this->major = $major;
    }


    public function index(Request $request)
    {
        $this->authorize('viewAny', Major::class);

        $users = $this->major->get($request);
        return view('major.index',[
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
        $this->authorize('create', Major::class);

        return view('major.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorRequest $request)
    {
        $this->authorize('create', Major::class);

        $major = $this->major->store($request);

        if (! $major) {
            $this->setFlash(__('Thêm ngành thất bại'), 'error');

            return redirect()->route('majors.create');
        }
        $this->setFlash(__('Thêm ngành thành công'));

        return redirect(route('majors.index'));
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

        $majorPolicy = Major::find($id);

        $this->authorize('update', $majorPolicy);

        $major = $this->major->getById($id);

        if (! $this->major->getById($id)) {
            $this->setFlash(__('Không tìm thấy ngành'), 'error');

            return redirect(route('majors.index'));
        }
        return view('major.edit',[
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
    public function update(MajorRequest $request, $id)
    {
        $majorPolicy = Major::find($id);

        $this->authorize('update', $majorPolicy);


        if ($this->major->update($request, $id)) {
            $this->setFlash(__('Cập nhật thông tin ngành thành công'));

            return redirect(route('majors.index'));
        }

        $this->setFlash(__('Cập nhật thông tin ngành thất bại thất bại'), 'error');

        return redirect(route('majors.edit', $id));
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
            'valid' => $this->major->checkName($data),
        ], StatusCode::OK);
    }
}
