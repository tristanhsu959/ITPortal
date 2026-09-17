<?php

namespace App\Models;

use App\Enums\RoleGroup;
use App\Enums\OpCenter;
use App\Enums\Area;
use Illuminate\Support\Fluent;

class CurrentUser extends Fluent
{
	public function __construct($userInfo)
	{
		$info['id'] 			= data_get($userInfo, 'userId', 0);
		$info['account'] 		= data_get($userInfo, 'userAccount', '');
		$info['displayName'] 	= data_get($userInfo, 'displayName', '');
		$info['department'] 	= data_get($userInfo, 'department', '');
		$info['email'] 			= data_get($userInfo, 'email', '');
		
		$info['roleName'] 		= data_get($userInfo, 'roleName', '');
		$info['roleGroupId'] 	= data_get($userInfo, 'roleGroupId', 0);
		$info['rolePermission'] = data_get($userInfo, 'rolePermission', []);
		
		$this->fill($info);
	}
	
	/* Show available name
	 * @params: 
	 * @return: boolean
	 */
	public function getAvailableName()
	{
		$account 	= $this->get('account');
		$name 		= $this->get('displayName', NULL);
		
		return empty($name) ? $account : $name;
	}
	
	/* 內建Supervisor (RoleGroup)
	 * @params:  
	 * @return: boolean
	 */
	public function isSupervisor()
	{
		$roleGroup = $this->get('roleGroupId', 0);
		
		return ($roleGroup == RoleGroup::SUPERVISOR->value);
	}
	
	/* Auth permission of function by current user
	 * @params: string
	 * @return: boolean
	 */
	public function hasFunctionPermission($functionKey)
	{
		if ($this->isSupervisor())
			return TRUE;
		
		$permissions	= $this->get('rolePermission', []);
		$allowFunctions	= array_values($permissions); #Key same as code
		
		return in_array($functionKey, $allowFunctions);
	}
	
	#改為只有判別功能,無CRUD
	/* Auth permission of function by current user
	 * @params: string
	 * @return: boolean
	 */
	public function hasPermissionTo($functionKey)
	{
		if ($this->isSupervisor())
			return TRUE;
		
		$permissions = $this->get('rolePermission', []);
		
		return in_array($functionKey, $permissions);
	}
	
	
	/* Get permission
	 * @params: 
	 * @return: boolean
	 */
	public function getPermissions()
	{
		if ($this->isSupervisor())
			return config('web.menu.enabled');
		
		return $this->get('rolePermission', []);
	}
	
	/* Get opcenter permission key
	 * @params: 
	 * @return: boolean
	 */
	public function getOpCenterPermissions()
	{
		$opList = $this->getOpCenterPermissionMap();
		
		return array_keys($opList);
	}
	
	/* Get opcenter permission key-value
	 * @params: 
	 * @return: boolean
	 */
	public function getOpCenterPermissionMap()
	{
		$opList = OpCenter::options();
		
		if ($this->isSupervisor())
			return $opList;
		
		$authOps = $this->get('roleArea.opCenter', []);
		
		$opList = collect($opList)->filter(function($item, $key) use($authOps) {
			return in_array($key, $authOps);
		})->toArray();
		
		return $opList;
	}
	
	/* Get area permission key
	 * @params: 
	 * @return: boolean
	 */
	public function getSalesAreaPermissions()
	{
		$areaList = $this->getSalesAreaPermissionMap();
		
		return array_keys($areaList);
	}
	
	/* Get area permission key-value
	 * @params: 
	 * @return: boolean
	 */
	public function getSalesAreaPermissionMap()
	{
		$areaList = Area::options();
		
		if ($this->isSupervisor())
			return $areaList;
		
		$authAreas = $this->get('roleArea.sales', []);
		
		$areaList = collect($areaList)->filter(function($item, $key) use($authAreas) {
			return in_array($key, $authAreas);
		})->toArray();
		
		return $areaList;
	}
	
	/* Get area permission key-value
	 * @params: 
	 * @return: boolean
	 */
	public function getPurchaseAreaPermissions()
	{
		$areaList = $this->getPurchaseAreaPermissionMap();
		
		return array_keys($areaList);
	}
	
	/* Get area permission key-value
	 * @params: 
	 * @return: boolean
	 */
	public function getPurchaseAreaPermissionMap()
	{
		$areaList = Area::options();
		
		if ($this->isSupervisor())
			return $areaList;
		
		$authAreas = $this->get('roleArea.purchase', []);
		
		$areaList = collect($areaList)->filter(function($item, $key) use($authAreas) {
			return in_array($key, $authAreas);
		})->toArray();
		
		return $areaList;
	}
	
	
	
	
}