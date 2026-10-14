@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
	<!--link href="{{ HelperLib::versionAsset('styles/tv_media/detail.css') }}" rel="stylesheet"-->
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/tv_media/detail.js') }}" defer></script>
@endpush

@section('content')

<main x-data="mediaData(@js($viewModel->responseDetail()))" class="responsive">
	<form :action="response.formAction" method="post" novalidate @submit.prevent="validate()" enctype="multipart/form-data" class="content-wrapper">
		<input type="hidden" name="id" :value="formData.id" x-model="formData.id">
		@csrf
		
		<section class="media-data grid">
			<div class="field s12 m12">
				<nav>
					<template x-for="(name, typeKey) in options.types" :key="typeKey">
						<label class="radio field-red">
							<input type="radio" name="type" x-model="formData.type" :value="typeKey">
							<span x-text="name"></span>
						</label>
					</template>
				</nav>
			</div>

			<div class="field label border s12 m3" :class="Helper.hasError(errors, 'name')">
				<input type="text" name="name" maxlength="15" required x-model="formData.name" @input="errors.delete('name')">
				<label>顯示名稱</label>
				<span class="red-text tiny"><i class="tiny">asterisk</i>必填</span>
			</div>
			
			<div x-show="formData.type == 'image'" class="field label border prefix s12 m9" :class="Helper.hasError(errors, 'uploadFile')">
				<i>attach_file</i>
				<input type="file" name="uploadFile" maxlength="256" required @change="handleFileChange" accept="image/png, image/jpeg" @input="errors.delete('uploadFile')" :disabled="formData.type != 'image'" x-ref="fileInput">
				<input type="text" maxlength="256">
				<label>圖檔</label>
				<span class="red-text"><i class="tiny">asterisk</i>必填：jpg/png</span>
			</div>
			
			<div x-show="formData.type == 'link'" class="field label border prefix s12 m9" :class="Helper.hasError(errors, 'uploadLink')">
				<i>media_link</i>
				<input type="text" name="uploadLink" maxlength="256" required x-model="formData.uploadLink" @input="errors.delete('uploadLink')" :disabled="formData.type != 'link'">
				<label>影片連結</label>
				<span class="red-text"><i class="tiny">asterisk</i>必填</span>
			</div>
			
			<div class="field label border s12 m3" :class="Helper.hasError(errors, 'stDate')">
				<input type="date" name="stDate" maxlength="10" x-model="formData.stDate" @input="errors.delete('stDate')">
				<label>開始時間</label>
			</div>
			
			<div class="field label border s12 m3" :class="Helper.hasError(errors, 'endDate')">
				<input type="date" name="endDate" maxlength="10" x-model="formData.endDate" @input="errors.delete('endDate')">
				<label>結束時間</label>
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