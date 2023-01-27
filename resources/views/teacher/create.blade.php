
@extends('layouts.admin')

@section('content')
    <create-teacher
        :data="{{json_encode([
            'urlBack' => route('teachers.index'),
            'urlStore' => route('teachers.store'),
            'urlCheckEmail' => route('students.checkmail'),
            'urlCheckPhone' => route('students.checkphone'),
            'major' => $major,
])}}">
    </create-teacher>
@endsection
