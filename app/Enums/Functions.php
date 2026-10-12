<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum Functions : string
{
	case HOME						= 'home';
	case USER						= 'user';
	case ROLE 						= 'role'; 
		
	#TV Menu	
	case TV_MEDIAS 					= 'tv:medias';
	case TV_MENUS					= 'tv:menus';
	case TV_STORE_MENUS				= 'tv:store_menus'; 
			
	public function label() : string
    {
        return match ($this) 
		{
			#權限系統管理
			self::HOME				=> '首頁',
			self::USER				=> '帳號管理',
			self::ROLE 				=> '身份管理',
				
			#TV Menu	
			self::TV_MEDIAS 		=> 'TV媒體庫',
			self::TV_MENUS			=> 'TV菜單',
			self::TV_STORE_MENUS	=> 'TV門市菜單',
        };
    }
	
	public static function getAll(): array
	{
		$list = [];
		foreach(self::cases() as $case)
		{
			$list[] = $case->value;
		}
		
		return $list;
	}
}
