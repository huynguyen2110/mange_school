<?php

namespace App\Repositories\Classes;

interface ClassInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function getSubjects();
    public function getTeachers();
    public function checkName($request);
    public function storeRegisterClass($request);
    public function cancelClass($request);
    public function changeStatus($id);
}
