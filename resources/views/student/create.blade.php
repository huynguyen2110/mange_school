
@extends('layouts.admin')

@section('content')
    <create-student
        :data="{{json_encode([
            'urlBack' => route('students.index'),
            'urlStore' => route('students.store'),
            'urlCheckEmail' => route('students.checkmail'),
            'urlCheckPhone' => route('students.checkphone'),
])}}">
    </create-student>
@endsection
