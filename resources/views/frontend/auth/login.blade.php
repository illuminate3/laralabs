@extends('frontend.layouts.centered')

@section('head.title', config('app.name') . " &laquo; " . trans('general.action.login'))

@section('page.content')
    @include('frontend.auth.partials.form-panel', [
        'formPartial' => 'frontend.auth.partials.forms.login',
        'footerLinks' => [
            // [ 'url' => route('frontend.auth.login.form'), 'label' => trans('general.action.login') ],
            [ 'url' => route('frontend.auth.register.form'), 'label' => trans('general.action.register') ],
            [ 'url' => route('frontend.auth.reset.form'), 'label' => trans('general.action.lost-password') ],
        ],
    ])
@endsection