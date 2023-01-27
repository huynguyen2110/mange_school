@extends('layouts.admin')

@section('content')
    <create-major
        :data="{{json_encode([
            'urlBack' => route('majors.index'),
            'urlStore' => route('majors.store'),
            'urlCheckName' => route('majors.checkname'),
])}}">
    </create-major>
@endsection
