<?php

namespace App\Traits;

use App\Enums\RoleGroup;
use App\Libraries\MenuLib;
use Illuminate\Support\Str;

/* 負責登入後相關授權邏輯判別 */
trait CurrentUserTrait
{
	const SESS_AUTH_USER = 'Sess:AuthUser';
	const SESS_AUTH_MENU = 'Sess:AuthMenu';
	
	
	/* 清除登入資訊|Menu
	 * @params: 
	 * @return: boolean
	 */
	public function removeCurrentUser()
	{
		session()->forget(self::SESS_AUTH_USER);
		session()->forget(self::SESS_AUTH_MENU);
		
		return TRUE;
	}
	
	/* 儲存登入資訊
	 * @params: array
	 * @params: array
	 * @return: boolean
	 */
	public function saveCurrentUser($adInfo, $userInfo)
	{
		$sessionData = array_merge($adInfo, $userInfo);
		session()->put(self::SESS_AUTH_USER, $sessionData);
		
		return TRUE;
	}
	
	/* Get current user
	 * @params: 
	 * @return: array
	 */
	public function getCurrentUser()
	{
		if (session()->missing(self::SESS_AUTH_USER))
			return FALSE;
		
		return session()->get(self::SESS_AUTH_USER);
	}
	
	/* Get current user permissions
	 * @params: 
	 * @return: array
	 */
	public function getSigninUserPermission()
	{
		$signinUser = $this->getSigninUserInfo();
		
		if (empty($signinUser))
			return [];
		
		$userPermission = $signinUser['permission'];
		
		return $userPermission;
	}
	
	
	
	/* 內建Supervisor (RoleGroup)
	 * @params:  
	 * @return: boolean
	 */
	public function isSupervisor()
	{
		$currentUser = $this->getSigninUserInfo();
		
		if (empty($currentUser))
			return FALSE;
		
		return ($currentUser['roleGroup'] == RoleGroup::SUPERVISOR->value);
	}
	
	/* 取已授權的Menu (登入驗後) : AppServiceProvider
	 * @params: 
	 * @return: array
	 */
	public function getAuthorizedMenu()
	{
		$authMenu = [];
		
		#1.若有取過, 直接取Session
		if (session()->has(self::SESS_AUTH_MENU))
			return session()->get(self::SESS_AUTH_MENU);
		
		#2.取功能選單-ALL
		$menuConfig = MenuLib::all();
		
		#3.驗證使用者有權限的選單, 只要驗證到功能即可
		foreach($menuConfig as $key => $group)
		{
			#$authMenu[$key] = $group;
			$authItems = [];
				
			foreach($group['items'] as $functions)
			{
				if ($this->hasFunctionPermission($functions['code']))
					$authItems[] = $functions;
			}
			
			if (! empty($authItems))
			{
				$authMenu[$key] = $group;
				$authMenu[$key]['items'] = $authItems;
			}
		}
		
		session()->put(self::SESS_AUTH_MENU, $authMenu);
		
		return $authMenu;
	}
	
	
	
	/* Auth permission of function by current user
	 * @params: string
	 * @return: boolean
	 */
	public function hasFunctionPermission($functionCode)
	{
		if ($this->isSupervisor())
			return TRUE;
		
		$userPermission		= $this->getSigninUserPermission();
		$functionCodeList	= array_keys($userPermission); #Key same as code
		
		return in_array($functionCode, $functionCodeList);
	}
	
	/* Auth permission of CRUD by current user
	 * @params: string
	 * @params: string
	 * @return: boolean
	 */
	public function hasOperationPermission($functionCode, $operationValue)
	{
		if ($this->isSupervisor())
			return TRUE;
		
		$userPermission = $this->getSigninUserPermission();
		$userOperations = data_get($userPermission, $functionCode, []); #array
		
		return in_array($operationValue, $userOperations);
	}
}