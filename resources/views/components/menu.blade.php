<!-- Menu component -->

<nav x-data="{menus:@js($menus), currentPath:@js($currentPath)}" x-show="$store.menu.active" class="menu left">
	<header class="primary-container">
		<img src="{{ asset('images/bf_logo.png') }}" />
		<span>IT Portal</span>
	</header>
	
	<div class="container responsive scroll">
		<template x-for="(groups, key) in menus">
			<details x-data="{ isOpen: groups.some(item => currentPath.includes(item.url)) }" :open="isOpen" @toggle="isOpen = $el.open">
				<summary>
					<span x-text="key"></span>
					<i class="none" x-text="isOpen ? 'stat_minus_1':'chevron_forward'"></i>
				</summary>
				
				<template x-for="item in groups">
				<div class="item">
					<a :href="item.url" :class="[currentPath.includes(item.url) ? 'active' : '', item.style.color]" class="responsive" @click="Alpine.store('app').isLoading = true">
						<i x-text="item.style.icon"></i>
						<span x-text="item.name" ></span>
					</a>
				</div>
				</template>
			</details>
		</template>
	</div>
</nav>
