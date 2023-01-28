
@extends('layouts.admin')

@section('content')
    <edit-class
        :data="{{json_encode([
            'urlBack' => route('classes.index'),
            'urlUpdate' => route('classes.update', $class->id),
            'urlCheckName' => route('classes.checkname'),
            'subject' => $subject,
            'class' => $class,
            'teacher' => $teacher,
])}}">
    </edit-class>
@endsection
