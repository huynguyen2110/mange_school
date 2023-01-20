<?php

namespace App\Repositories\Student;

use App\Enums\UserRole;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Repositories\Student\StudentInterface;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Paginator;

class StudentRepository extends BaseController implements StudentInterface
{
    private User $student;
    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $studentBuilder = $this->student
                ->orderBy('cre_at', 'desc');

        if (isset($request['search_input'])) {
            $studentBuilder = $studentBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('address', $request['search_input']));
            });
        }
        $students = $studentBuilder->paginate($newSizeLimit);
        if ($this->checkPaginatorList($students)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $students = $studentBuilder->paginate($newSizeLimit);
        }

        return $students;
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function store($request)
    {
        // TODO: Implement store() method.
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
