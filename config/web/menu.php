<?php

use App\Enums\MenuGroup;
use App\Enums\Functions;
use Illuminate\Support\Str;

#Menu Config (key與route要相同)
return [
	#Group (Enable List)
	MenuGroup::TVMenu->value => [
		[
			'name' 		=> Functions::TV_MEDIAS->label(), 
			'code'		=> Functions::TV_MEDIAS->value,
			'style' 	=> ['icon' => 'animated_images', 'color' => 'orange-text'],
			'url' 		=> 'medias',
		],
		[
			'name' 		=> Functions::TV_MENUS->label(), 
			'code'		=> Functions::TV_MENUS->value,
			'style' 	=> ['icon' => 'menu_book_2', 'color' => 'orange-text'],
			'url' 		=> 'medias',
		],
		[
			'name' 		=> Functions::TV_STORE_MENUS->label(), 
			'code'		=> Functions::TV_STORE_MENUS->value,
			'style' 	=> ['icon' => 'live_tv', 'color' => 'orange-text'],
			'url' 		=> 'medias',
		],
	],
	
	MenuGroup::MANAGE->value => [
		[
			'name' 		=> Functions::USER->label(), #帳號管理,
			'code'		=> Functions::USER->value,
			'style' 	=> ['icon' => 'admin_panel_settings', 'color' => 'pink-text'],
			'url' 		=> 'users', 
		],
		
		[
			'name' 		=> Functions::ROLE->label(), #身份管理,
			'code'		=> Functions::ROLE->value,
			'style' 	=> ['icon' => 'how_to_reg', 'color' => 'pink-text'],
			'url' 		=> 'roles', 
		],
	],
];
