{!! BootForm::open()
        ->action(route('frontend.auth.reset.change'))
        ->post() !!}

{!! BootForm::hidden('token')->value($token)  !!}
{!! BootForm::email(trans('general.field.email'), 'email')  !!}
{!! BootForm::password(trans('general.field.password'), 'password')  !!}
{!! BootForm::password(trans('general.field.password_confirmation'), 'password_confirmation')  !!}

{!! BootForm::submit(trans('general.action.do_password_reset'), 'btn btn-primary btn-block auth-submit') !!}

{!! BootForm::close() !!}