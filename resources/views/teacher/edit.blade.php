
@extends('layouts.admin')

@section('content')
    <edit-teacher
        :data="{{json_encode([
            'urlBack' => route('teachers.index'),
            'urlUpdate' => route('teachers.update', $teacher->uuid),
            'urlCheckEmail' => route('students.checkmail'),
            'urlCheckPhone' => route('students.checkphone'),
            'teacher' => $teacher,
])}}">
    </edit-teacher>
@endsection
