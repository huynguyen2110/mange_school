@extends('layouts.admin')

@section('content')
    <create-subject
        :data="{{json_encode([
            'urlBack' => route('subjects.index'),
            'urlStore' => route('subjects.store'),
            'urlCheckName' => route('subjects.checkname'),
            'major' => $major,
])}}">
    </create-subject>
@endsection
