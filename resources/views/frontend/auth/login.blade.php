@extends('frontend.layouts.centered')

@section('page.content')

    @include('frontend.auth.partials.form', [
        'formPartial' => 'frontend.auth.partials.login.form',
        'footerLinks' => [
            // [ 'url' => route('frontend.auth.login.form'), 'label' => trans('general.action.login') ],
            [ 'url' => route('frontend.auth.register.form'), 'label' => trans('general.action.register') ],
            [ 'url' => route('frontend.auth.reset.form'), 'label' => trans('general.action.lost-password') ],
        ],
    ])


@endsection