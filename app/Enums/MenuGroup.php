<?php

namespace App\Enums;

enum MenuGroup : int
{
	case TVMenu		= 1;
    case MANAGE		= 99;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::TVMenu		=> 'TV Menu',
			self::MANAGE 		=> '系統管理',
        };
    }
}
