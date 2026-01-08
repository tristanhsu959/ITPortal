<?php

namespace App\ViewModels;

use App\ViewModels\Attributes\attrStatus;
use App\ViewModels\Attributes\attrActionBar;
use App\ViewModels\Attributes\attrAllowAction;
use App\Enums\FormAction;
use App\Enums\Operation;
use App\Enums\RoleGroup;
use App\Enums\Functions;


class UserViewModel
{
	use attrStatus, attrActionBar, attrAllowAction;
	
	private $_title 	= '帳號管理';
	private $_function	= Functions::USER->value;
	private $_backRoute	= 'user'; #set by route name
	private $_data 		= [];
	
	public function __construct()
	{
		#initialize
		$this->_data['action'] 	= FormAction::LIST; #default
		$this->success();
		
		#Form Data
		$this->_data['user'] 	= NULL; #DB data
		$this->_data['list'] 	= []; #DB data
		$this->_data['search']	= [];
		$this->_data['option']	= [];
	}
	
	public function __set($name, $value)
    {
		$this->_data[$name] = $value;
    }
	
	public function __get($name)
    {
		return data_get($this->_data, $name, '');
	}
	
	/* 須有isset, 否則empty()會判別錯誤 */
	public function __isset($name)
    {
		return array_key_exists($name, $this->_data);
	}
	
	/* 判別列表的使用者是否可刪除(除登入者權限外)
	 * @params: int : 欲刪除的user id
	 * @params: int : 欲刪除的user role group
	 * @return: boolean
	 */
	public function canDeleteThisUser($userId, $roleGroup)
	{
		#當前使用者(即自己)/Supervisor不可刪
		return ! ($this->isCurrentUser($userId) OR (RoleGroup::SUPERVISOR->value == $roleGroup));
	}
	
	/* Form submit action
	 * @params: 
	 * @return: string
	 *
	public function getFormAction() : string
    {
		return match($this->action)
		{
			FormAction::CREATE => route('user.create.post'),
			FormAction::UPDATE => route('user.update.post'),
		};
	}*/
	
	/* Form所屬的參數選項
	 * @params:  
	 * @return: void
	 */
	/* private function _setOptions()
	{
		$this->_data['option']['area'] 		= Area::cases(); #enum
		$this->_data['option']['roleList']	= $this->_service->getRoleOptions();
	} */
	
	/* Keep search data of form
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: string
	 */
	/* public function keepSearchData($adAccount, $displayName, $area)
    {
		data_set($this->_data, 'search.userAd', $adAccount);
		data_set($this->_data, 'search.userDisplayName', $displayName);
		data_set($this->_data, 'search.userAreaId', $area);
	} */
	
	/* Get search data
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: string
	 */
	/* public function getSearchAd()
	{
		return data_get($this->_data, 'search.userAd', '');
	}
	
	public function getSearchName()
	{
		return data_get($this->_data, 'search.userDisplayName', '');
	}
	
	public function getSearchArea()
	{
		return data_get($this->_data, 'search.userAreaId', 0);
	} */
	
	/* Keep user form data
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: void
	 */
	/* public function keepFormData($id = 0, $adAccount = '', $displayName = '', $role = 0)
    {
		data_set($this->_data, 'userData.id', $id);
		data_set($this->_data, 'userData.ad', $adAccount);
		data_set($this->_data, 'userData.displayName', $displayName);
		data_set($this->_data, 'userData.roleId', $role);
	} */
	
	/* Get user data
	 * @params: 
	 * @return: string
	 */
	/* public function getUserId()
    {
		return data_get($this->_data, 'userData.id', 0);
	}
	
	public function getUserAd()
	{
		return data_get($this->_data, 'userData.ad', '');
	}
	
	public function getUserDisplayName()
	{
		return data_get($this->_data, 'userData.displayName', '');
	}
	
	public function getUserRoleId()
	{
		return data_get($this->_data, 'userData.roleId', 0);
	} */
	
	/* User Data End */
	
	/* Get role name of list
	 * @params: int
	 * @return: string
	 */
	/* public function getRoleById($roleId)
	{
		$list = $this->_data['option']['roleList'];
		return data_get($list, $roleId, '');
	} */
	
	
	#Page operation permission
	#判別登入使用者權限
	/* Delete permission
	 * @params: 
	 * @return: boolean
	 */
	
	
	
	
	
	/* Search form */
	/* public function selectedSearchArea($areaId)
	{
		return ($areaId == $this->getSearchArea());
	}
	
	
	public function checkedRole($roleId)
	{
		$userRoleId = $this->getUserRoleId();
		
		return ($roleId == $userRoleId);
	} */
	
	
}