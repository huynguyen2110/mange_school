@extends('layouts.admin')

@section('content')
    <create-course
        :data="{{json_encode([
            'urlBack' => route('courses.index'),
            'urlStore' => route('courses.store'),
            'urlCheckName' => route('courses.checkname'),
])}}">
    </create-course>
@endsection

