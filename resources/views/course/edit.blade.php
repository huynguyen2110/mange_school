
@extends('layouts.admin')

@section('content')
    <edit-course
        :data="{{json_encode([
            'urlBack' => route('courses.index'),
            'urlUpdate' => route('courses.update', $course->id),
            'urlCheckName' => route('courses.checkname'),
            'course' => $course,
])}}">
    </edit-course>
@endsection
