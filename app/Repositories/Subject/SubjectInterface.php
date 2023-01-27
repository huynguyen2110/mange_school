<?php

namespace App\Repositories\Subject;

interface SubjectInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function getMajors();
    public function checkName($request);
}
