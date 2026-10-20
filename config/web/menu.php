<?php

use App\Enums\MenuGroup;
use App\Enums\Functions;
use Illuminate\Support\Str;

#Menu Config (key與route要相同)
return [
	MenuGroup::ORDER->value => [
		[
			'name' 		=> Functions::ORDER_POS->label(), 
			'code'		=> Functions::ORDER_POS->value,
			'style' 	=> ['icon' => 'restaurant', 'color' => 'orange-text'],
			'url' 		=> 'order.pos',
		],
		[
			'name' 		=> Functions::ORDER_PURCHASE->label(), 
			'code'		=> Functions::ORDER_PURCHASE->value,
			'style' 	=> ['icon' => 'local_shipping', 'color' => 'orange-text'],
			'url' 		=> 'order.purchase',
		],
		[
			'name' 		=> Functions::ORDER_EZORDER->label(), 
			'code'		=> Functions::ORDER_EZORDER->value,
			'style' 	=> ['icon' => 'qr_code', 'color' => 'orange-text'],
			'url' 		=> 'order.ezorder',
		],
	],
	
	#Group (Enable List)
	/* MenuGroup::AUTH->value => [
		[
			'name' 		=> Functions::AUTH_METHOD->label(), 
			'code'		=> Functions::AUTH_METHOD->value,
			'style' 	=> ['icon' => 'verified', 'color' => 'orange-text'],
			'url' 		=> 'auth_method',
		],
		[
			'name' 		=> Functions::TV_MENU->label(), 
			'code'		=> Functions::TV_MENU->value,
			'style' 	=> ['icon' => 'menu_book_2', 'color' => 'orange-text'],
			'url' 		=> 'menus',
		],
		[
			'name' 		=> Functions::TV_STORE_MENU->label(), 
			'code'		=> Functions::TV_STORE_MENU->value,
			'style' 	=> ['icon' => 'live_tv', 'color' => 'orange-text'],
			'url' 		=> 'store_menus',
		],
	], */
	
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
