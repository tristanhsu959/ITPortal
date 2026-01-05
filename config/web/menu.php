<?php

use App\Enums\Permission;

return [
	
	#由這裏控制順序/enabled/disabled
	'enabled' => [
		'users',
		'roles',
	],
	
	#Function
	'available' => [
		'users' => [
			'name' 		=> '帳號管理',
			'url' 		=> 'users',
			'style'		=> ['icon' => 'account_circle', 'width' => 'w1'],
			'permissions'=> [
				Permission::READ, Permission::CREATE, Permission::UPDATE, Permission::DELETE, 
			],
		],
		'roles' => [
			'name' 		=> '身份管理',
			'url' 		=> 'roles',
			'style'		=> ['icon' => 'group', 'width' => 'w1'],
			'permissions'=> [
				Permission::READ, Permission::CREATE, Permission::UPDATE, Permission::DELETE, 
			],
		],
	],
];
