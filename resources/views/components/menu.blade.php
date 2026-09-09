<!-- Menu component -->

<nav x-data="{menus:@js($menus), currentPath:@js($currentPath)}" class="menu left l m scroll" :class="$store.menu.active ? 'max':''">
	<header>
		<img src="{{ asset('images/bf_logo.png') }}" />
		<span x-show="$store.menu.active">IT Portal</span>
	</header>
	
	<template x-for="item in menus">
		<a :href="item.url" :class="[currentPath.includes(item.url) ? 'active' : '', item.style.color]" @click="Alpine.store('app').isLoading = true">
			<i x-text="item.style.icon"></i>
			<span x-text="item.name"></span>
			<span x-text="name"></span>
		</a>
	</template>
</nav>
