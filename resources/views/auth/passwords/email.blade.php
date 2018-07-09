@extends('admin.layouts.auth')

<!-- Main Content -->
@section('content')
<form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
    {{ csrf_field() }}
    <div class="form-title">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>
<form class="forget-form" role="form" method="POST" action="{{ url('/register') }}">
    <div class="form-title">
        <span class="form-title"><?php echo trans('auth.forgot_password');?>?</span>
        <span class="form-subtitle"><?php echo trans('auth.enter_your_email_to_reset_it');?>.</span>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" class="form-control placeholder-no-fix" autocomplete="off" placeholder="<?php echo trans('auth.email');?>" name="email" value="{{ old('email') }}">
        @if ($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="form-actions">
        <a href="{{ url('/login')}}" class="btn btn-default"><?php echo trans('general.back');?></a>
        <button type="submit" id="register-submit-btn" class="btn red uppercase pull-right"><?php echo trans('general.submit');?></button>
    </div>
</form>
@endsection
