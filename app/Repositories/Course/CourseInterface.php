<?php

namespace App\Repositories\Course;

interface CourseInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function checkName($request);
}
