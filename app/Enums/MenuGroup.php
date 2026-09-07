<?php

namespace App\Enums;

enum MenuGroup : int
{
	case SALE_ORDER		= 1;
    case PURCHASE_ORDER = 2;
	case FJVEGGIE 	= 3;
	case DATA		= 70;
	case PRODUCT	= 80;
	case MANAGE		= 99;
	
	public function label() : string
    {
        return match ($this) 
		{
			self::SALE_ORDER		=> '銷售訂單查詢',
			self::PURCHASE_ORDER 	=> '出貨訂單查詢',
			self::FJVEGGIE 	=> '芳珍',
			self::DATA 		=> '資料維護',
			self::PRODUCT 	=> '產品設定',
			self::MANAGE 	=> '系統管理',
        };
    }
}
