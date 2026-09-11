@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
	<link href="{{ HelperLib::versionAsset('styles/role/detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/role/detail.js') }}" defer></script>
@endpush

@section('content')
<main x-data="roleData(@js($viewModel->responseDetail()))" class="app responsive">
	<form :action="response.formAction" method="post" novalidate @submit.prevent="validate()" class="content-wrapper scroll">
		<input type="hidden" name="id" :value="formData.id" x-model="formData.id">
		<input type="hidden" name="groupId" :value="formData.groupId" x-model="formData.groupId">
		<input type="hidden" name="updateAt" :value="formData.updateAt" x-model="formData.updateAt">
		@csrf
		
		<section class="role-data grid">
			
			<template x-if="formData.id > 0">
				<label class="large-text s12 m12" x-text="`更新時間：${formData.updateAt}`"></label>
			</template>
			
			<div class="field label border s12 m3 prefix" :class="Helper.hasError(errors, 'name')">
				<i class="small red-text">asterisk</i>
				<input type="text" name="name" maxlength="15" required x-model="formData.name" @input="errors.delete('name')">
				<label>身份名稱</label>
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

			<!-- Tabs -->
			<article class="s12 secondary-container">
				<div class="tabs cyan-text">
					<template x-for="(groups, groupName) in options.functions" :key="groupName">
						<a :data-ui="`#page-${groupName}`" x-text="groupName" :class="activeTab == groupName ? 'active':''" ></a>
					</template>
				</div>
				
				<template x-for="(groups, groupName) in options.functions" :key="`list-${groupName}`">
				<div class="page padding" :id="`page-${groupName}`" :class="activeTab == groupName ? 'active':''">
					<fieldset class="role-permission field-blue fieldset required surface-container-high">
						<ul class="list border">
							<template x-for="(item, idx) in groups" :key="idx">
								<li>
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
				</div>
				</template>
			</article>
		</section>
		
		<nav class="toolbar surface-container-high">
			<button type="submit" class="btn-light-green small-width" x-text="response.actionLabel"></button>
			<button type="button" class="square round transparent" @click="reset()">重置</button>
		</nav>
		
	</form>
</main>
@endsection