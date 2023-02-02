@extends('layouts.guest')

@section('content')
    <reset-password
        :data="{{json_encode([
            'urlStore' => route('store-reset-password'),
            'urlLogin' => route('login'),
            'message' => isset($message) ? $message : '',
])}}">
    </reset-password>
@endsection
