@extends('layouts.app')
@use('App\Libraries\HelperLib')

@push('styles')
    <!--link href="{{ HelperLib::versionAsset('styles/home/main.css') }}" rel="stylesheet"-->
@endpush

@push('scripts')
    <!--script src=""></script-->
@endpush

@section('content')
<section class="content-wrapper">
	<pre class="red-border"><i class="right-padding">commit</i>版本更新日期：2026-xx-xx</pre>
	<pre class="red-border"><i class="right-padding">commit</i>版本更新後，請按 <code class="grey white-text tiny-padding">Ctrl</code> + <code class="grey white-text tiny-padding">F5</code> 清除瀏覽器暫存</pre>
</section>
@endsection
