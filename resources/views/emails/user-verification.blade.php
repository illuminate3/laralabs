@extends('emails.layouts.master')

@section('email.title', trans('emails.auth.verify-account.title'))

@section('email.content')
    {!! trans('emails.auth.verify-account.content', [
        'url' => route('frontend.auth.verification.form', ['token' => $user->verification_token]) . '?email=' . urlencode($user->email)
    ]) !!}
@endsection
