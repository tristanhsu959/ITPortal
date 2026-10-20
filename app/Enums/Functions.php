<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum Functions : string
{
	case HOME				= 'home';
	case USER				= 'user';
	case ROLE 				= 'role'; 
	
	case ORDER_POS			= 'order:pos';
	case ORDER_PURCHASE		= 'order:purchase';
	case ORDER_EZORDER		= 'order:ezorder';
	
	#case AUTH_METHOD		= 'auth:method';
			
	public function label() : string
    {
        return match ($this) 
		{
			#權限系統管理
			self::HOME				=> '首頁',
			self::USER				=> '帳號管理',
			self::ROLE 				=> '身份管理',
			
			self::ORDER_POS			=> 'POS訂單查詢',
			self::ORDER_PURCHASE	=> '訂貨訂單查詢',
			self::ORDER_EZORDER		=> '八方點訂單查詢',
	
			#Auth account by multi methods	
			#self::AUTH_METHOD 		=> '驗證模式',
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
