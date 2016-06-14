@extends('frontend.layouts.centered')

@section('head.title', config('app.name'))

@section('page.content')
    @if (session('status'))
        <div class="row">
            <div class="col-sm-6">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <div class="text-center">
        <h1>Hello world!</h1>
    </div>
@endsection