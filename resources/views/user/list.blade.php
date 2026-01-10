@extends('layouts.app')

@push('styles')
    <link href="{{ asset('styles/user/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/user/list.js') }}" defer></script>
@endpush

@section('content')
@if($viewModel->status() === TRUE)
	
	@if($viewModel->canUpdate())
	<form action="" method="post" id="userForm">@csrf</form>
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
				<label for="searchArea" class="form-label">身份</label>
			</div>
			<button class="btn btn-search btn-info" type="button">
				<span class="material-symbols-outlined filled-icon">search</span>
			</button>
			<button id="btnReset" type="button" class="btn btn-dark btn-search-reset">
				<span class="material-symbols-outlined">backspace</span>
			</button>
		</form>
		
		@if($viewModel->canCreate())
		<a href="{{ route('user.create.get') }}" class="btn btn-create">
			<span class="material-symbols-outlined filled-icon">add</span>
		</a>
		@endif
	</section>
	
	<section class="user-list section-wrapper">
		@if(empty(($viewModel->list)))
		<div class="alert alert-danger" role="alert">
			查無符合資料
		</div>
		@else
		<div class="container-fluid list-data grid">
			<div class="d-table w-100">
				<div class="d-table-row head">
					<div class="d-table-cell">#</div>
					<div class="d-table-cell">AD帳號</div>
					<div class="d-table-cell">顯示名稱</div>
					<div class="d-table-cell">身份</div>
					<div class="d-table-cell">工號|部門</div>
					<div class="d-table-cell">EMail</div>
					<div class="d-table-cell">更新時間</div>
					<div class="d-table-cell">操作</div>
				</div>
				@foreach($viewModel->list as $idx => $user)
				<div class="d-table-row">
					<div class="d-table-cell">{{ $idx + 1 }}</div>
					<div class="d-table-cell">{{ $user['userAd'] }}</div>
					<div class="d-table-cell">{{ $user['adDisplayName'] }}</div>
					<div class="d-table-cell">{{ $user['roleName'] }}</div>
					<div class="d-table-cell">
						{{ $user['adEmployeeId'] }}
						@if(! empty($user['adDepartment']))
						<span class="badge rounded-pill bg-primary">{{ $user['adDepartment'] }}<span>
						@endif
					</div>
					<div class="d-table-cell">{{ $user['adMail'] }}</div>
					<div class="d-table-cell cell-date">2025-11-11 11:11:11</div>
					<div class="d-table-cell cell-action">
						<a href="{{ route('user.update.get', [$user['userId']]) }}" class="btn btn-edit @disabled(!$viewModel->canUpdate())">
							<span class="material-symbols-outlined">edit</span>
						</a>
						<a href="{{ route('user.delete.post', [$user['userId']]) }}" class="btn btn-delete @disabled(!($viewModel->canDelete() && $viewModel->canDeleteThisUser($user['userId'], $user['roleGroup'])))">
							<span class="material-symbols-outlined">delete</span>
						</a>
					</div>
				</div>
				@endforeach
			</div>
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