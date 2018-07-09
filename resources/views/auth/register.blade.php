@extends('auth.auth')

@section('content')
<!-- BEGIN REGISTRATION FORM -->
<h1>Register</h1>
<form class="register-form" style="display:block" role="form" method="POST" action="{{ url('/register') }}">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Full Name');?></label>
        <input id="name" type="text" class="form-control placeholder-no-fix" name="name" placeholder="<?php echo trans('Full Name');?>" value="{{ old('name') }}" />
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Email');?></label>
        <input id="email" type="email" class="form-control placeholder-no-fix" name="email" value="{{ old('email') }}" placeholder="<?php echo trans('Email');?>" />
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="control-label visible-ie8 visible-ie9"><?php echo trans('auth.password');?></label>
        <input id="password" type="password" class="form-control placeholder-no-fix" name="password" placeholder="<?php echo trans('auth.password');?>" />
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm" class="control-label visible-ie8 visible-ie9"><?php echo trans('auth.confirm_password');?></label>
        <input id="password-confirm" type="password" class="form-control placeholder-no-fix" name="password_confirmation" placeholder="<?php echo trans('auth.confirm_password');?>" />
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
    <input name="role" value="1" type="hidden" />
    <div class="form-actions">
        <button type="submit" id="register-submit-btn" class="btn btn-primary"><?php echo trans('auth.submit');?></button>
        <a href="{{ url('/login')}}" class="btn btn-default"><?php echo trans('Login');?></a>
    </div>
</form>
<!-- END REGISTRATION FORM -->
@endsection