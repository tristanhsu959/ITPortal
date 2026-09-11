<!-- Dialog -->

<dialog x-data id="modal-dialog">
	<nav :class="$store.dialog.color">
		<i x-text="$store.dialog.icon"></i>
		<h6 x-text="$store.dialog.title">Title</h6>
    </nav>
	
	<div class="message padding" x-text="$store.dialog.message"></div>
	
	<nav class="right-align no-space">
		<button x-show="!$store.dialog.isConfirm" class="border primary" data-ui="#modal-dialog">確認</button>
		<button x-show="$store.dialog.isConfirm" @click="$store.dialog.confirm()" class="border primary">確認</button>
		<button x-show="$store.dialog.isConfirm" class="transparent link" data-ui="#modal-dialog">取消</button>
	</nav>
</dialog>
