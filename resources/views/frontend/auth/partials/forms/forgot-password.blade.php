{!! BootForm::open()
        ->action(route('frontend.auth.password.forgot.submit'))
        ->post() !!}

{!! BootForm::email(trans('general.field.email'), 'email')  !!}

{!! BootForm::submit(trans('general.action.request_password_reset'), 'btn btn-primary btn-block auth-submit') !!}

{!! BootForm::close() !!}