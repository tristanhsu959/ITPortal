@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
    <link href="{{ HelperLib::versionAsset('styles/sales/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/sales/list.js') }}" defer></script>
@endpush

@section('content')
<!-- Search panel -->
<dialog x-data="searchSales(@js($viewModel->searchFormData()))" id="searchPanel" class="right">
	<form :action="searchData.formAction" method="post" id="searchForm" novalidate @submit.prevent="search()" class="vertical">
	@csrf
		<h5>查詢</h5>
		
		<div class="field middle-align">
			<nav class="wrap">
				<template x-for="(name, id) in options.type" :key="id">
					<label class="radio field-red">
						<input type="radio" name="searchType" x-model="searchData.type" :value="id">
						<span x-text="name"></span>
					</label>
				</template>
			</nav>
		</div>
		
		<div class="field label border round field-light-blue" :class="Helper.hasError(errors, 'stDate')">
			<input type="date" name="searchStDate" maxlength="10" x-model="searchData.stDate" @input="errors.delete('stDate')" :max="searchData.today">
			<label>開始日期</label>
		</div>
		
		<div class="field label border round field-light-blue" :class="Helper.hasError(errors, 'endDate')">
			<input type="date" name="searchEndDate" maxlength="10" x-model="searchData.endDate" @input="errors.delete('endDate')" :max="searchData.today">
			<label>結束日期</label>
		</div>
		
		<fieldset x-show="Object.keys(options.areaList).length > 0" class="field light-blue-border light-blue-text">
			<legend class="small">選擇區域</legend>
			<nav class="wrap">
				<template x-for="(areaName, areaId) in options.areaList" :key="areaId">
				<label class="checkbox check-pink">
					<input type="checkbox" :value="areaId" name="searchAreaIds[]" x-model="searchData.areaIds">
					<span x-text="areaName"></span>
				</label>
				</template>
			</nav>
			<output class="red-text small">未選時取全部授權區域</output>
		</fieldset>
		
		<div class="field label border round field-light-blue">
			<input type="text" name="searchStoreName" maxlength="10" x-model="searchData.storeName" x-ref="searchStoreName" @input="errors.delete('storeName')">
			<label>找店名</label>
		</div>
		
		<div class="field label suffix round border field-light-blue" :class="Helper.hasError(errors, 'category')">
			<select x-model="searchData.category" name="searchCategory" @change="errors.delete('category')">
				<option value="">請選擇</option>
				<template x-for="(name, catId) in options.category" :key="catId">
					<option x-text="name" :value="catId" :selected="searchData.category == catId"></option>
				</template>
			</select>
			<label>類別</label>
			<i>arrow_drop_down</i>
			<output x-text="`已選 ${searchData.productIds.length} 個項目`" class="red-text"></output>
		</div>
		
		<template x-for="(products, catId) in options.products" :key="catId">
			<fieldset x-show="searchData.category == catId" class="field-dark-blue fieldset">
				<legend><i class="small red-text">asterisk</i><span>請勾選產品</span></legend>
				<template x-for="(item, idx) in products" :key="idx">
					<div class="row">
						<label class="checkbox large s3 check-amber">
							<input type="checkbox" :name="`searchProductIds[]`" x-model="searchData.productIds" :value="item.id">
							<span x-text="item.name"></span>
						</label>
					</div>
				</template>
			</fieldset>
		</template>
			
		<div class="space"></div>
		<nav class="right-align group split">
			<button type="submit" class="btn-search left-round large"><i>search</i>查詢</button>
			<button @click="resetSearch()" type="button" class="btn-search-reset right-round square large"><i>backspace</i></button>
		</nav>
	</form>
</dialog>
<!-- Search panel end -->

<main x-data="userList(@js($viewModel->responseList()))" class="responsive">
	<header class="page-nav">
		<nav>
			<a :href="response.createRoute" class="button square green"><i>add</i></a>
			
			<nav x-show="response.hasResult" class="group connected filter">
				<div class="field label border prefix filter-dark small">
					<i>filter_alt</i>
					<input type="text" x-model="$store.userFilter.filter">
					<label>篩選</label>
				</div>
				<button class="square" @click="$store.userFilter.reset()"><i>backspace</i></button>
			</nav>
		</nav>
	</header>
	
	<section x-show="response.status === true && !response.hasResult" class="content-wrapper">
		<article class="error-container border">
			<div class="row">
				<i>info</i><div class="max">尚無設定</div>
			</div>
		</article>
	</section>
	
	<form x-show="response.status === true && response.hasResult" action="" method="post" x-ref="userListForm" class="content-wrapper padding-top">
		@csrf
		
		<div class="grid-table">
			<!-- head -->
			<div class="table-head grid-row">
				<div class="th">#</div>
				<div class="th">帳號</div>
				<div class="th">顯示名稱</div>
				<div class="th">權限身份</div>
				<div class="th">部門</div>
				<div class="th">EMail</div>
				<div class="th">狀態</div>
				<div class="th">登入時間</div>
				<div class="th right-align">操作</div>
			</div>
			
			<!-- row -->
			<template x-for="(user, idx) in filterUsers" :key="idx">
				<div class="table-row grid-row">
					<div class="td" x-text="idx+1"></div>
					<div class="td" x-text="user.userAccount"></div>
					<div class="td" x-text="user.displayName"></div>
					<div class="td">
						<span x-text="user.roleName"></span>
						<span>
							<i class="green-text" x-show="user.isRoleActive">check_circle</i>
							<i class="red-text" x-show="! user.isRoleActive">x_circle</i>
							<span class="tooltip right" x-text="user.isRoleActive ? '啟用':'停用'"></span>
						</span>
					</div>
					<div class="td" x-text="user.department"></div>
					<div class="td" x-text="user.email"></div>
					<div class="td">
						<span>
							<i class="green-text fill large" x-show="user.isActive">check_circle</i>
							<i class="red-text fill large" x-show="! user.isActive">x_circle</i>
							<span class="tooltip right" x-text="user.isActive ? '啟用':'停用'"></span>
						</span>
					</div>
					<div class="td" x-text="user.accessTime"></div>
					<div class="td right-align action">
						<a :href="response.updateRoute.replace('_ID', user.userId)" class="button square small small-elevate orange">
							<i class="small">edit</i>
						</a>
						<a :href="response.deleteRoute.replace('_ID', user.userId)" @click.prevent="confirmDelete($el.href)" class="button square small small-elevate deep-orange">
							<i class="small">delete</i>
						</a>
					</div>
				</div>
			</template>
		</div>
	</form>

</main>

@endsection