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
			self::TVMenu		=> '電視菜單',
			self::MANAGE 		=> '系統管理',
        };
    }
}
