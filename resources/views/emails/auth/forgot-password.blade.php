@extends('emails.layouts.master')

@section('email.title', trans('emails.auth.forgot-password.title'))

@section('email.content')
{!! trans('emails.auth.forgot-password.content', [
    'url' => route('frontend.auth.password.reset.form', ['token' => $token]) . '?email=' . urlencode($user->getEmailForPasswordReset())
]) !!}
@endsection
