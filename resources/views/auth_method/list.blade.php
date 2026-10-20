@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
    <link href="{{ HelperLib::versionAsset('styles/auth_method/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ HelperLib::versionAsset('scripts/auth_method/list.js') }}" defer></script>
@endpush

@section('content')
<!-- Content -->
<main x-data="" class="responsive">
	<form action="" method="post" x-ref="userListForm" class="content-wrapper padding-top">
		@csrf
		
		<ul class="list border">
			<li>
				<i class="extra fill green-text">check_circle</i>
				<i class="extra fill red-text">cancel</i>
				<i class="extra primary-text">help</i>
				<div class="max">
					<h6 class="small">AD驗證</h6>
					<div class="pink-text">N/A</div>
				</div>
				<button class="green">驗證</button>
			</li>
			<li>
				<i class="extra fill green-text">check_circle</i>
				<i class="extra fill red-text">cancel</i>
				<i class="extra primary-text">help</i>
				<div class="max">
					<h6 class="small">BPM驗證</h6>
					<div class="pink-text">N/A</div>
				</div>
				<button class="green">驗證</button>
			</li>
		</ul>
	</form>
</main>
<!-- Content -->
@endsection