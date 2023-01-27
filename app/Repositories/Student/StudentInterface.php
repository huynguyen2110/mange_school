<?php

namespace App\Repositories\Student;

interface StudentInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function checkEmail($request);
    public function checkPhone($request);
    public function getMajors();
    public function getCourses();
}
