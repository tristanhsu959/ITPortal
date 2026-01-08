@extends('layouts.app')

@push('styles')
    <link href="{{ asset('styles/user/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/user/list.js') }}" defer></script>
@endpush

@section('content')
@if($viewModel->status() === TRUE)
	
	@if($viewModel->canCreate() || $viewModel->canUpdate())
	<form action="" method="post" id="userForm">@csrf</form>
	@endif
	
	@if($viewModel->canCreate())
	<a href="{{ route('user.create.get') }}" class="btn btn-create">
		<span class="material-symbols-outlined filled-icon">add</span>
		<span class="title">新增</span>
	</a>
	@endif
	
	@if ($viewModel->canQuery())
	<section class="searchbar section-wrapper">
		<form action="{{ route('user.search') }}" method="post" id="searchForm">
			@csrf
			<div class="input-field field-blue field">
				<input type="text" class="form-control valid" id="searchAd" name="searchAd" value="{{ $viewModel->searchAd }}" maxlength="20" placeholder=" ">
				<label for="searchAd" class="form-label">AD帳號</label>
			</div>
			<div class="input-field field-blue field">
				<input type="text" class="form-control valid" id="searchName" name="searchName" value="{{ $viewModel->searchName }}" maxlength="20" placeholder=" ">
				<label for="searchName" class="form-label">顯示名稱</label>
			</div>
			<div class="input-select field-blue field">
				<select class="form-select" id="searchArea" name="searchArea">
					<option value="">請選擇</option>
					<option value="1"  >test</option>
					<option value="1"  >test</option>
					<option value="1"  >test</option>
				</select>
				<label for="searchArea" class="form-label">管理區域</label>
			</div>
			<button class="btn btn-search btn-info" type="button">
				<span class="material-symbols-outlined filled-icon">search</span>
			</button>
			<button id="btnReset" type="button" class="btn btn-dark btn-search-reset">
				<span class="material-symbols-outlined">backspace</span>
			</button>
		</form>
	</section>
	
	<section class="user-list section-wrapper">
		@if(empty(($viewModel->list)))
		<div class="container-fluid empty-list">
			<div class="row">
				<div class="col">查無符合資料</div>
			</div>
		</div>
		@else
		<div class="container-fluid list-data grid">
			<div class="row head">
				<div class="col col-1">#</div>
				<div class="col">AD帳號</div>
				<div class="col">顯示名稱</div>
				<div class="col">身份</div>
				<div class="col col-3">部門|工號|EMail</div>
				<div class="col col-2">更新時間</div>
				<div class="col col-action">操作</div>
			</div>
			@foreach($viewModel->list as $idx => $user)
			<div class="row">
				<div class="col col-1">{{ $idx + 1 }}</div>
				<div class="col">{{ $user['userAd'] }}</div>
				<div class="col">{{ $user['adDisplayName'] }}</div>
				<div class="col">{{ $user['roleName'] }}</div>
				<div class="col col-3">dsfdsfd
				</div>
				<div class="col col-2">2025-11-11 11:11:11</div>
				<div class="col col-action">
					<a href="{{ route('user.update.get', [$user['userId']]) }}" class="btn btn-edit @disabled(!$viewModel->canUpdate())">
						<span class="material-symbols-outlined">edit</span>
					</a>
					<a href="{{ route('user.delete.post', [$user['userId']]) }}" class="btn btn-delete @disabled(!$viewModel->canDeleteThisUser($user['userId'], $user['roleGroup']))">
						<span class="material-symbols-outlined">delete</span>
					</a>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</section>
	@else
	<section class="user-list section-wrapper">
		<div class="alert alert-danger" role="alert">
		此帳號無查詢權限
		</div>
	</section>
	@endif
	
@endif <!-- Status -->
@endsection