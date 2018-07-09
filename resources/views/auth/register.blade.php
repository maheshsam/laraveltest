@extends('auth.auth')

@section('content')
<!-- BEGIN REGISTRATION FORM -->
<h1>Register</h1>
<form class="register-form" style="display:block" role="form" method="POST" action="{{ url('/register') }}">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('general.full_name');?></label>
        <input id="name" type="text" class="form-control placeholder-no-fix" name="name" placeholder="<?php echo trans('general.full_name');?>" value="{{ old('name') }}" />
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('general.email');?></label>
        <input id="email" type="email" class="form-control placeholder-no-fix" name="email" value="{{ old('email') }}" placeholder="<?php echo trans('general.email');?>" />
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
    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('general.address');?></label>
        <textarea id="address" rows="3" class="form-control placeholder-no-fix" name="address" placeholder="<?php echo trans('general.address');?>">{{ old('address') }}</textarea>
        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('general.phone');?></label>
        <input id="phone" type="text" class="form-control  placeholder-no-fix" placeholder="<?php echo trans('general.phone');?>" name="phone" value="{{ old('phone') }}" />
        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
    <input name="role" value="1" type="hidden" />
    <div class="form-actions">
        <button type="submit" id="register-submit-btn" class="btn btn-primary"><?php echo trans('auth.submit');?></button>
        <a href="{{ url('/login')}}" class="btn btn-default"><?php echo trans('general.login');?></a>
    </div>
</form>
<!-- END REGISTRATION FORM -->
@endsection