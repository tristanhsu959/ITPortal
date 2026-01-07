@extends('layouts.app')
@use('App\Enums\AuthType')

@push('styles')
    <link href="{{ asset('styles/signin.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/signin.js') }}" defer></script>
@endpush

@section('signin')

	<section class="head">
		<img src="{{ asset('images/logo.svg') }}" />
	</section>
	<div class="divider"><span>IT<i>Portal</i></span></div>
	<section class="content-wrapper">
		<form action="{{ route('signin.post') }}" method="post" id="signinForm">
			@csrf
			<div class="input-field field-purple">
				<input type="text" class="form-control" id="account" name="account" value="{{ $viewModel->account }}" maxlength="20" placeholder=" " required>
				<label for="account" class="form-label">AD帳號</label>
				<span class="inline-hint">@8way.com.tw</span>
			</div>
			<div class="input-field field-purple">
				<input type="password" class="form-control" id="password" name="password" placeholder=" " maxlength="20" required>
				<label for="password" class="form-label">密碼</label>
			</div>
			<div class="footer">
				<button id="btnSignin" type="button" class="btn btn-red">登入</button>
				<button id="btnReset" type="button" class="btn btn-dark"><span class="material-symbols-outlined">backspace</span></button>
			</div>
			<div class="radio-group">
				<label for="ad">
					<input type="radio" id="ad" name="authType" value="{{ AuthType::AD->value }}" @checked(AuthType::AD->value == $viewModel->authType) >
					{{ AuthType::AD->label() }}
				</label>
				<label for="system">
					<input type="radio" id="system" name="authType" value="{{ AuthType::SYSTEM->value }}" @checked(AuthType::SYSTEM->value == $viewModel->authType)>
					{{ AuthType::SYSTEM->label() }}
				</label>
			</div>
		</form>
	</section>

@endsection()