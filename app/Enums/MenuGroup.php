<?php

namespace App\Enums;

enum MenuGroup : int
{
	case ORDER		= 1;
    case MANAGE		= 99;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::ORDER		=> '訂單',
			self::MANAGE 	=> '系統管理',
        };
    }
}
