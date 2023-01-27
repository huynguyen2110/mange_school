
@extends('layouts.admin')

@section('content')
    <edit-subject
        :data="{{json_encode([
            'urlBack' => route('subjects.index'),
            'urlUpdate' => route('subjects.update', $subject->id),
            'urlCheckName' => route('subjects.checkname'),
            'subject' => $subject,
            'major' => $major,
])}}">
    </edit-subject>
@endsection
