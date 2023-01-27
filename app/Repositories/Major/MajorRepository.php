<?php

namespace App\Repositories\Major;

use App\Enums\UserRole;
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

class MajorRepository extends BaseController implements MajorInterface
{
    private Major $major;
    public function __construct(Major $major)
    {
        $this->major = $major;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $majorBuilder = $this->major
            ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $majorBuilder = $majorBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
            });
        }
        $majors = $majorBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($majors)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $majors = $majorBuilder->paginate($newSizeLimit);
        }

        return $majors;
    }

    public function getById($id)
    {
        return $this->major->where('id', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $major = new $this->major();
            $major->name = $request->name;
            $major->founded_year = date("Y");

            if (! $major->save()) {
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

            $major = $this->major->where('id', $id)->first();
            $major->name = $request->name;


            if (! $major->save()) {
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
            return ! $this->major->where(function ($query) use ($request) {
                if (isset($request['id'])) {
                    $query->where('id', '!=', $request['id']);
                }
                $query->where(['name' => $request['value']]);
            })->exists();
        }
        if (isset($request['name']) != '') {
            return $this->major->where('name', $request['name'])->exists();
        }

        return true;
    }
}
