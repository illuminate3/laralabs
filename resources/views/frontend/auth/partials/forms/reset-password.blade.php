{!! BootForm::open()
        ->action(route('frontend.auth.password.reset.submit'))
        ->post() !!}

{!! BootForm::hidden('token')->value($token)  !!}
{!! BootForm::hidden('email')->value($email)  !!}
{!! BootForm::password(trans('general.field.new_password'), 'password')->helpBlock(trans('general.field.password_help'))  !!}
{!! BootForm::password(trans('general.field.password_confirmation'), 'password_confirmation')  !!}

{!! BootForm::submit(trans('general.action.do_password_reset'), 'btn btn-primary btn-block auth-submit') !!}

{!! BootForm::close() !!}