<?php

namespace App\Repositories\Subject;

use App\Models\Major;
use App\Models\Subject;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Paginator;

class SubjectRepository extends BaseController implements SubjectInterface
{
    private Subject $subject;
    private Major $major;
    public function __construct(Subject $subject, Major $major)
    {
        $this->subject = $subject;
        $this->major = $major;
    }


    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $subjectBuilder = $this->subject
            ->with('majors')
            ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $subjectBuilder = $subjectBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
            });
        }
        $subjects = $subjectBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($subjects)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $subjects = $subjectBuilder->paginate($newSizeLimit);
        }

        return $subjects;
    }

    public function getById($id)
    {
        return $this->subject->where('id', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $subject = new $this->subject();
            $subject->name = $request->name;
            $subject->major_id = $request->major_id;

            if (! $subject->save()) {
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

            $subject = $this->subject->where('id', $id)->first();
            $subject->name = $request->name;
            $subject->major_id = $request->major_id;


            if (! $subject->save()) {
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

    public function getMajors()
    {
        return $this->major->get();
    }

    public function checkName($request)
    {
        if (isset($request['value']) != '') {
            return ! $this->subject->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('id', '!=', $request['id']);
                }
                $query->where(['name' => $request['value']]);
            })->exists();
        }
        if (isset($request['name']) != '') {
            return $this->subject->where('name', $request['name'])->exists();
        }

        return true;
    }
}
