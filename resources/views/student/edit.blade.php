
@extends('layouts.admin')

@section('content')
    <edit-student
        :data="{{json_encode([
            'urlBack' => route('students.index'),
            'urlUpdate' => route('students.update', $student->uuid),
            'urlCheckEmail' => route('students.checkmail'),
            'urlCheckPhone' => route('students.checkphone'),
            'student' => $student,
])}}">
    </edit-student>
@endsection
