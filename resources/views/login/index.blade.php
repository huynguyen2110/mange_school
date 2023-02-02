@extends('layouts.guest')

@section('content')
    <login
        :data="{{json_encode([
            'urlStore' => route('store-login'),
            'urlForgotPassword' => route('forgot-password'),
])}}">
    </login>
@endsection
