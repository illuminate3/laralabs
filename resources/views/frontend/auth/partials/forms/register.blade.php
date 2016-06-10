{!! BootForm::open()
        ->action(route('frontend.auth.register.submit'))
        ->post() !!}

<div class="row">
    <div class="col-md-6">
        {!! BootForm::text(trans('general.field.name'), 'name')  !!}
    </div>
    <div class="col-md-6">
        {!! BootForm::text(trans('general.field.email'), 'email')  !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! BootForm::password(trans('general.field.password'), 'password')  !!}
    </div>
    <div class="col-md-6">
        {!! BootForm::password(trans('general.field.password_confirmation'), 'password_confirmation')  !!}
    </div>
</div>


{!! BootForm::submit(trans('general.action.register'), 'btn btn-primary btn-block auth-submit') !!}

{!! BootForm::close() !!}