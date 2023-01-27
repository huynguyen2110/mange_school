
@extends('layouts.admin')

@section('content')
    <edit-major
        :data="{{json_encode([
            'urlBack' => route('majors.index'),
            'urlUpdate' => route('majors.update', $major->id),
            'urlCheckName' => route('majors.checkname'),
            'major' => $major,
])}}">
    </edit-major>
@endsection
