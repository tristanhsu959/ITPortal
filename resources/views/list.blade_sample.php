@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
	<link href="{{ HelperLib::versionAsset('styles/role/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/role/list.js') }}" defer></script>
@endpush

@section('content')
<main x-data="roleList(@js($viewModel->responseList()))" class="app responsive">
	<header class="page-nav">
		<nav>
			<a :href="response.createRoute" class="button circle green"><i>add</i></a>
			
			<nav x-show="response.hasResult" class="group connected filter">
				<div class="field label border prefix filter-dark small">
					<i>filter_alt</i>
					<input type="text" x-model="$store.roleFilter.filter">
					<label>篩選</label>
				</div>
				<button class="square" @click="$store.roleFilter.reset()"><i>backspace</i></button>
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
	
	<form x-show="response.status === true && response.hasResult" action="" method="post" x-ref="roleListForm" class="content-wrapper padding-top">
		@csrf
		
		<div class="grid-table">
			<!-- head -->
			<div class="table-head table-row">
				<div class="th">#</div>
				<div class="th">名稱</div>
				<div class="th">狀態</div>
				<div class="th">更新時間</div>
				<div class="th right-align">操作</div>
			</div>
			
			<!-- row -->
			<template x-for="(role, idx) in filterRoles" :key="idx">
				<div class="table-row">
					<div class="td" x-text="idx+1"></div>
					<div class="td" x-text="role.roleName"></div>
					<div class="td">
						<span>
							<i class="green-text fill" x-show="role.isActive">check_circle</i>
							<i class="red-text fill" x-show="! role.isActive">x_circle</i>
							<span class="tooltip right" x-text="role.isActive ? '啟用':'停用'"></span>
						</span>
					</div>
					<div class="td" x-text="role.updateAt"></div>
					<div class="td right-align action">
						<a :href="response.updateRoute.replace('_ID', role.roleId)" class="button square small small-elevate orange" :disabled="role.roleGroupId == response.supervisorGroupId">
							<i class="small">edit</i>
						</a>
						<a :href="response.deleteRoute.replace('_ID', role.roleId)" @click.prevent="confirmDelete($el.href)" class="button square small small-elevate deep-orange" :disabled="role.roleGroupId == response.supervisorGroupId">
							<i class="small">delete</i>
						</a>
					</div>
				</div>
			</template>
		</div>

		<table class="stripes border odd-cyan">
			<thead>
				<tr>
					<th class="min">#</th>
					<th>名稱</th>
					<th>狀態</th>
					<th>更新時間</th>
					<th class="right-align">操作</th>
				</tr>
			</thead>
			<tbody>
			<template x-for="(role, idx) in filterRoles" :key="idx">
				<tr>
					<td x-text="idx+1"></td>
					<td x-text="role.roleName"></td>
					<td>
						<i class="green-text fill" x-show="role.isActive">check_circle</i>
						<i class="red-text fill" x-show="! role.isActive">x_circle</i>
					</td>
					<td class="min" x-text="role.updateAt"></td>
					<td class="right-align action">
						<a :href="response.updateRoute.replace('_ID', role.roleId)" class="button square small small-elevate orange" :disabled="role.roleGroupId == response.supervisorGroupId">
							<i class="small">edit</i>
						</a>
						<a :href="response.deleteRoute.replace('_ID', role.roleId)" @click.prevent="confirmDelete($el.href)" class="button square small small-elevate deep-orange" :disabled="role.roleGroupId == response.supervisorGroupId">
							<i class="small">delete</i>
						</a>
					</td>
				</tr>
			</template>
			</tbody>
		</table>
		
	</form>
</main>
<!-- Content -->

@endsection