@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/signin.js') }}" defer></script>
@endpush

@section('content')

<div x-data="login(@js($viewModel->responseData()))" class="content-wrapper">
	<form :action="formData.formAction" method="post" class="grid" novalidate @submit.prevent="validate()" >
		@csrf
		
		<div class="s12 head-logo">
			<img src="{{ asset('images/logo.svg') }}" />
			<span class="title" x-show="!showForgotPassword">Sign in to IT Portal</span>
			<span class="title" x-show="showForgotPassword">Forgot Password</span>
		</div>
		
		<div class="s12 m12 form-content">
			<!--div class="head">
				<img src="{{ asset('images/logo.svg') }}" />
				<h6 x-show="!showForgotPassword">登入至 IT Portal</h6>
				<h6 x-show="showForgotPassword">忘了吃銀杏嗎？</h6>
			</div-->
			
			<div class="field label border" :class="Helper.hasError(errors, 'account')">
				<input x-model="formData.account" type="text" name="account" maxlength="20" @input="errors.delete('account')">
				<label>帳號</label>
			</div>
			
			
			<div x-show="!showForgotPassword" class="field label border" :class="Helper.hasError(errors, 'password')">
				<input x-model="formData.password" type="password" name="password" maxlength="20" @input="errors.delete('password')">
				<label>密碼</label>
			</div>
			
			<p x-show="showForgotPassword" class="red-text">系統會發送密碼設定連結至此帳號所屬信箱，<br/>請由該連結進入密碼重設頁面</p>
			
			<div class="field label border captcha">
				<input type="text" name="captcha" maxlength="10">
				<label>Captcha</label>
			</div>
			
			<nav class="group split">
				<button x-show="!showForgotPassword" type="submit" class="left-round max">
					<span>登入</span>
				</button>
				<button x-show="showForgotPassword" type="submit" class="green left-round max">
					<span>送出</span>
				</button>
				<button type="button" class="red right-round square" @click="reset()">
					<i>close</i>
				</button>
			</nav>
			
			<nav>
				<div class="max"></div>
				<button type="button" class="right pink-text transparent" @click="showForgotPassword = !showForgotPassword">
					<i x-show="showForgotPassword">password_2_off</i>
					<i x-show="!showForgotPassword">password_2</i>
					<span>忘了吃銀杏?</span>
				</button>
			</nav>
		</div>
		
	</form>
</div>	
		

	
<!--div>
		<!--div class="divider vertical"></div->
		
		<div class="content-right">
			<div x-show="!isForgetPassword" class="header">
				<img src="{{ asset('images/bf_logo.png') }}" @dblclick="showOidcButton = !showOidcButton" />
				<span class="title">Sign In</span>
				<h6>登入至 IT Portal</h6>
			</div>
			<div x-show="isForgetPassword" class="header">
				<img src="{{ asset('images/microsoft_logo.png') }}" />
				<span class="title">Forgot Password</span>
				<h6>忘記密碼？</h6>
			</div>
			
			<div class="field label border" :class="Helper.hasError(errors, 'account')">
				<input x-model="formData.account" type="text" name="account" maxlength="20" @input="errors.delete('account')">
				<label>Account</label>
				<!--span class="domain">@8way.com.tw</span->
			</div>
			<div x-show="!isForgetPassword" class="field label border" :class="Helper.hasError(errors, 'password')">
				<input x-model="formData.password" type="password" name="password" maxlength="20" @input="errors.delete('password')">
				<label>Password</label>
			</div>
			<p x-show="isForgetPassword" class="red-text">系統會發送密碼設定連結至此帳號所屬信箱，請由該連結進入密碼重設頁面</p>
			<div class="field label border captcha">
				<input type="text" name="captcha" maxlength="10">
				<label>Captcha</label>
			</div>
			<nav class="group split">
				<button x-show="!isForgetPassword"  type="submit" class="btn-red left-round max">
					<span>Sign In</span>
				</button>
				<button x-show="isForgetPassword"  type="submit" class="btn-light-blue left-round max">
					<span>送出</span>
				</button>
				<button type="button" class="right-round square btn-cancel" @click="reset()">
					<i>close</i>
				</button>
			</nav>
			
		</div>
	
	
	<a x-show="showOidcButton" :href="formData.oethRedirect" class="button extend circle light-blue10 btn-oidc">
		<!--i>fingerprint</i->
		<img class="responsive" src="{{ asset('images/oeth.png') }}">
		<span>OETH Auth</span>
	</a>
</div-->

@endsection