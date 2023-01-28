@extends('layouts.admin')

@section('content')
    <create-class
        :data="{{json_encode([
            'urlBack' => route('classes.index'),
            'urlStore' => route('classes.store'),
            'urlCheckName' => route('classes.checkname'),
            'teacher' => $teacher,
            'subject' => $subject,
])}}">
    </create-class>
@endsection

