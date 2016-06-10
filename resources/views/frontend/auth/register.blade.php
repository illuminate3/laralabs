@extends('frontend.layouts.centered')

@section('head.title', config('app.name') . " &laquo; " . trans('general.action.register'))

@section('page.content')
    @include('frontend.auth.partials.form-panel', [
        'formPartial' => 'frontend.auth.partials.forms.register',
        'footerLinks' => [
            [ 'url' => route('frontend.auth.login.form'), 'label' => trans('general.action.login') ],
            // [ 'url' => route('frontend.auth.register.form'), 'label' => trans('general.action.register') ],
            [ 'url' => route('frontend.auth.reset.form'), 'label' => trans('general.action.lost_password') ],
        ],
        'panelClasses' => 'col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3',
    ])
@endsection
