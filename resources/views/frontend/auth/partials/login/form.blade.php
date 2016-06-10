{!! BootForm::open()
        ->action(route('frontend.auth.login.submit'))
        ->post() !!}

{!! BootForm::text(trans('general.field.email'), 'email')  !!}
{!! BootForm::password(trans('general.field.password'), 'password')  !!}
{!! BootForm::checkbox(trans('general.field.remember-me'), 'remember_me')  !!}

{!! BootForm::submit(trans('general.action.login'), 'btn btn-primary center-block auth-submit') !!}

{!! BootForm::close() !!}