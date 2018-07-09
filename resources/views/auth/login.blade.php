@extends('auth.auth')

@section('content')
<!-- BEGIN LOGIN FORM -->
<form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
    {{ csrf_field() }}
    <div class="form-title">
        <span class="form-title"><?php echo trans('general.welcome'); ?>.</span>
        <span class="form-subtitle"><?php echo trans('auth.please_login');?>.</span>
    </div>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span><?php echo trans('auth.please_enter_valid_email_and_password');?></span>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('general.email'); ?></label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="<?php echo trans('general.email');?>" /> 
        @if ($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('auth.password');?></label>
        <input id="password" type="password" name="password" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="<?php echo trans('auth.password');?>" />
        @if ($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?php echo trans('auth.login');?></button>
    </div>
    <div class="form-actions">
        <div class="pull-left">
            <label class="rememberme mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1" /> <?php echo trans('auth.remember_me');?>
                <span></span>
            </label>
        </div>
        <div class="pull-right forget-password-block">
            <a href="{{ url('/password/reset')}}" id="forget-password" class="forget-password"><?php echo trans('auth.forgot_password');?>?</a>
        </div>
    </div>
    <div class="create-account">
        <p>
            <a href="{{ url('/register')}}" class="btn-info btn" id="register-btn"><?php echo trans('auth.register_now');?></a>
        </p>
    </div>
</form>
<!-- END LOGIN FORM -->
@endsection