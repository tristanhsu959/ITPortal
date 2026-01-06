<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>八方雲集-IT Portal</title>
		
		<link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
		
		<!-- Styles & Font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
		<link href="{{ asset('styles/common.css') }}" rel="stylesheet" />
		<link href="{{ asset('styles/app.css') }}" rel="stylesheet" />
		
		@stack('styles')
		
		<!-- Scripts -->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous" defer></script>
		<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js" integrity="sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=" crossorigin="anonymous" defer></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" defer></script>
		<script src="{{ asset('scripts/app.js') }}" defer></script>
		@stack('scripts')
	</head>

	<body>
		@hasSection('signin')
			<main class="signin">
				@yield('signin')
			</main>	
		@else
			<main class="app">
				<x-menu />
				
				<section class='content-wrapper'>
					<x-action-bar :breadcrumb="$viewModel->breadcrumb()" :routeName="$viewModel->backRoute()"/>
					
					@hasSection('content')
						@yield('content')
					@endif
				</section>
				
				<x-profile />
			</main>
			
			@include('layouts._dialog')
			
		@endif
		
		@include('layouts._toast')
	</body>
</html>
