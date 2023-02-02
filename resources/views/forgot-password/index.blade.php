@extends('layouts.guest')

@section('content')
    <forgot-password
        :data="{{json_encode([
            'urlStore' => route('store-forgot-password'),
])}}">
    </forgot-password>
@endsection
