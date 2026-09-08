<?php

namespace App\Enums;

enum RoleGroup : int
{
	case SUPERVISOR		= 1; #default
    case USER_DEFINED 	= 2;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::SUPERVISOR	=> 'SuperVisor',
			self::USER_DEFINED 	=> '使用者',
        };
    }
}
