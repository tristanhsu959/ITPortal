@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
	<link href="{{ HelperLib::versionAsset('styles/role/detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/role/detail.js') }}" defer></script>
@endpush

@section('content')
<div x-data="roleData(@js($viewModel->responseDetail()))" class="content-wrapper">
	<form action="response.formAction" method="post" novalidate @submit.prevent="validate()" class="container1">
		<input type="hidden" name="id" :value="response.formData.id" x-model="response.formData.id">
		@csrf
		
		
		<section class="role-data grid">
			<template x-if="formData.id > 0">
				<label class="large-text" x-text="`更新時間：${formData.updateAt}`"></label>
			</template>
			
			<div class="field label border field-purple s3 prefix" :class="Helper.hasError(errors, 'name')">
				<i class="small red-text">asterisk</i>
				<input type="text" name="name" maxlength="20" required x-model="formData.name" @input="errors.delete('name')">
				<label>身份名稱</label>
			</div>
			
			
			<template x-for="(groups, groupName) in options.functions" :key="groupName">
			<fieldset class="role-permission field-purple fieldset required">
				<legend x-text="groupName"></legend>
				<ul class="list border">
					<template x-for="(item, idx) in groups" :key="idx">
					<li class="">
						<div class="max">
							<h6 class="small"></h6>
							<div x-text="item.name"></div>
						</div>
						<label class="switch field-dark-blue">
							<input x-model="formData.permission" type="checkbox" name="permission[]" :value="item.code">
							<span></span>
						</label>
					</li>
					</template>
				</ul>
			</fieldset>
			</template>
			
			<fieldset class="role-area field-blue fieldset required">
				<legend>管理區域</legend>
				<template x-for="(areaName, areaId) in options.areas" :key="areaId">
					<label class="form-check-label" :for="`area-${areaId}`">
						<input x-model="formData.area" class="form-check-input" type="checkbox" name="area[]" :id="`area-${areaId}`" :value="areaId">
						<span x-text="areaName"></span>
					</label>
				</template>
			</fieldset>
		
			<div class="space"></div>
			<nav class="toolbar">
				<button type="submit" class="button btn-save btn-primary slow-ripple">{{ $viewModel->action->label()}}</button>
				<button @click="reset() "type="button" class="button btn-cancel border slow-ripple" id="btnReset">重置</button>
			</nav>
		</section>
	</form>
</section>
@endsection