<?php

use App\Enums\RoleGroup;
use App\Enums\Functions;
use App\Enums\Operation;

return [
	#Group (不直接與function關聯)
	'groups' => [
		[
			'name'	=> '權限管理',
			'style' => ['icon' => 'admin_panel_settings', 'class' => 'red'],
			'type' 	=> [RoleGroup::ADMIN->name, RoleGroup::SUPERVISOR->name],
			'items' => [
				'users',
				'roles',
			],
		],
	],
	
	#Function
	'functions' => [
		Functions::USER->value => [
			'name' 		=> Functions::USER->label(),
			'url' 		=> 'user', 
			'operation'	=> [
				Operation::READ, Operation::CREATE, Operation::UPDATE, Operation::DELETE, 
			],
		],
		Functions::ROLE->value => [
			'name' 		=> Functions::USER->label(),
			'url' 		=> 'role',
			'operation'	=> [
				Operation::READ, Operation::CREATE, Operation::UPDATE, Operation::DELETE, 
			],
		],
			
	],
];
