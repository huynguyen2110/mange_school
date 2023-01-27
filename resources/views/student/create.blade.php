
@extends('layouts.admin')

@section('content')
    <create-student
        :data="{{json_encode([
            'urlBack' => route('students.index'),
            'urlStore' => route('students.store'),
            'urlCheckEmail' => route('students.checkmail'),
            'urlCheckPhone' => route('students.checkphone'),
            'major' => $major,
            'course' => $course
])}}">
    </create-student>
@endsection
