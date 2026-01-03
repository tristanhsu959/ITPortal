@extends('layouts.app')

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
				<input type="text" class="form-control" id="adAccount" name="adAccount" value="{{-- $viewModel->adAccount --}}" maxlength="20" placeholder=" " required>
				<label for="adAccount" class="form-label">Account</label>
				<span class="domain-text">@8way.com.tw</span>
			</div>
			<div class="input-field field-purple">
				<input type="password" class="form-control" id="adPassword" name="adPassword" placeholder=" " maxlength="20" required>
				<label for="adPassword" class="form-label">Password</label>
			</div>
			<div class="footer">
				<button id="btnSignin" type="button" class="btn btn-bd-red">Sign In</button>
				<button id="btnReset" type="button" class="btn btn-dark"><span class="material-symbols-outlined">backspace</span></button>
			</div>
		</form>
	</section>

@endsection()