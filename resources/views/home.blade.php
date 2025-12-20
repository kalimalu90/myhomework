@extends('layout')

@section('title', 'Home')

@section('content')
    <h1>{{ __('messages.welcome') }}</h1>
    <p>{{ __('messages.home_page_description') }}</p>
@endsection
