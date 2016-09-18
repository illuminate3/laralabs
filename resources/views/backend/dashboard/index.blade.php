@extends('backend.layouts.master')

@section('head.title', config('app.name') . " &laquo; " . trans('views.backend.dashboard.title'))

@section('page.content')
    <div class="text-center">
        <h1>Hello world!</h1>
    </div>
@endsection