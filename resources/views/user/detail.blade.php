@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
	<link href="{{ HelperLib::versionAsset('styles/user/detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/user/detail.js') }}" defer></script>
@endpush

@section('content')

<main x-data="userData(@js($viewModel->responseDetail()))" class="responsive">
	<form :action="response.formAction" method="post" novalidate @submit.prevent="validate()" class="content-wrapper">
		<input type="hidden" name="id" :value="formData.id" x-model="formData.id">
		@csrf
		
		<section class="user-data grid">
			<template x-if="formData.id > 0">
				<label class="large-text s12 m12" x-text="`更新時間：${formData.updateAt}`"></label>
			</template>
			
			<div class="field label border s12 m2">
				<input type="text" name="displayName" maxlength="15" x-model="formData.displayName">
				<label>顯示名稱</label>
			</div>
			
			<div class="field label border s12 m2">
				<input type="text" name="department" maxlength="15" required x-model="formData.department">
				<label>部門</label>
			</div>
			
			<div class="field label border s12 m2" :class="Helper.hasError(errors, 'userRoleId')">
				<select x-model="formData.roleId" name="roleId" @change="errors.delete('roleId')">
					<option value="0" :selected="formData.roleId == 0">請選擇</option>
					<template x-for="(item, idx) in options.roleList" :key="idx">
						<option x-text="item.roleName" :value="item.roleId" :selected="formData.roleId == item.roleId"></option>
					</template>
				</select> 
				<label><i class="small red-text">asterisk</i>身份</label>
				<i>arrow_drop_down</i>
			</div>
			
			<div class="s12"></div>
			<div class="field label border prefix s12 m2" :class="Helper.hasError(errors, 'account')">
				<i class="small red-text">asterisk</i>
				<input type="text" name="account" maxlength="20" required x-model="formData.account" @input="errors.delete('account')">
				<label>帳號</label>
			</div>
			
			<div class="field label border prefix suffix s12 m2" :class="Helper.hasError(errors, 'password')">
				<i class="small red-text">asterisk</i>
				<input :type="showPassword ? 'text':'password'" name="password" maxlength="15" required x-model="formData.password" @input="errors.delete('password')">
				<label>密碼</label>
				<output class="red-text">英文+數字六個字元以上</output>
				<i class="btn-icon">
					<button type="button" class="large circle transparent prefix" @click="showPassword = !showPassword">
						<i x-show="!showPassword">visibility</i>
						<i x-show="showPassword">visibility_off</i>
					</button>
				</i>
			</div>
			
			<div class="s12"></div>
			
			<div class="field label border prefix s12 m4" :class="Helper.hasError(errors, 'email')">
				<i class="small red-text">asterisk</i>
				<input type="text" name="email" maxlength="50" required x-model="formData.email" @input="errors.delete('email')">
				<label>EMail</label>
			</div>
			
			<div class="field middle-align s3 field-light-green">
				<nav>
					<label class="switch">
						<input type="checkbox" name="isActive" x-model="formData.isActive" value="1" :checked="formData.isActive">
						<span></span>
					</label>
					<div>
						<span>啟用</span>
					</div>
				</nav>
			</div>
		</section>
		
		<nav class="toolbar surface-container-high">
			<button type="submit" class="green small-width" x-text="response.actionLabel"></button>
			<button type="button" class="square round transparent" @click="reset()">重置</button>
		</nav>
	</form>
</main>

@endsection