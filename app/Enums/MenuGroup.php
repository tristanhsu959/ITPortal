<?php

namespace App\Enums;

enum MenuGroup : int
{
	case SALE		= 1;
    case PURCHASE	= 2;
	/* case FJVEGGIE 	= 3;
	case DATA		= 70;
	case PRODUCT	= 80;
	 */
	case MANAGE		= 99;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::SALE		=> '銷售',
			self::PURCHASE 	=> '訂貨',
			self::MANAGE 	=> '系統管理',
        };
    }
}
