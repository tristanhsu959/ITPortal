<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;
use Log;

class AuthRepository extends Repository
{
	#Windows default is case-insensitive, Linex is case-sensitive
	#mysql是系統預設改不了或無效|檔案有分(table name)|Column & data似乎依編碼沒分
	public function __construct()
	{
		
	}
	
	/* Get user by account
	 * @params: string
	 * @return: array
	 */
	public function getUserByAccount($account)
	{
		try
		{
			$db = $this->connectItPortal('user as u');
				
			$result = $db
					->leftJoin('user_role as ur', 'ur.userId', '=', 'u.userId')
					->leftJoin('role as r', 'r.roleId', '=', 'ur.roleId')
					->where('u.userAccount', '=', $account)
					->select('u.userId', 'u.userAccount', 'u.userPassword')
					->addSelect('u.displayName', 'u.department', 'u.email', 'u.isActive')
					->addSelect('r.roleId', 'r.roleName', 'r.roleGroupId', 'r.rolePermission', 'r.isActive as isRoleActive')
					->get()
					->first();
			
			#有取到user才轉
			if (! empty($result))
				$result['rolePermission'] = empty($result['rolePermission']) ? [] : json_decode($result['rolePermission'], TRUE);
			
			return $result;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return FALSE;
		}
	}
}
