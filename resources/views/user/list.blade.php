@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
    <link href="{{ HelperLib::versionAsset('styles/user/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/user/list.js') }}" defer></script>
@endpush

@section('content')
<!-- Content -->
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
<!-- Content -->
@endsection