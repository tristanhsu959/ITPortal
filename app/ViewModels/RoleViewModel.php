<?php

namespace App\ViewModels;

use App\Facades\AppManager;
use App\Enums\FormAction;
use App\Enums\RoleGroup;
use App\Enums\Functions;
use App\ViewModels\Attributes\attrStatus;
use App\ViewModels\Attributes\attrActionBar;
use App\ViewModels\Attributes\attrAllowAction;
use Illuminate\Support\Fluent;

class RoleViewModel extends Fluent
{
	use attrStatus, attrActionBar, attrAllowAction;
	
	public function __construct()
	{
		$this->function		= Functions::ROLE;
		$this->action 		= FormAction::LIST; 
		$this->backRoute 	= 'roles';
		$this->success();
	}
	
	/* initialize
	 * @params: enum
	 * @return: void
	 */
	public function initialize($action)
	{
		#初始化各參數及Form Options
		$this->action = $action;
		
		$this->initializeState();
		$this->_setOptions();
	}
	
	/* Form所屬的參數選項
	 * @params:  
	 * @return: void
	 */
	private function _setOptions()
	{
		$this->set('options.functions', AppManager::getMenu()); 
		$this->set('options.supervisorGroupId', RoleGroup::SUPERVISOR->value); 
	}
	
	/* Keep user form data
	 * @params: int
	 * @params: string
	 * @params: int
	 * @params: array
	 * @params: array
	 * @return: void
	 */
	public function keepFormData($id = 0, $name = '', $permission = [], $isActive = TRUE, $updateAt = NULL)
    {
		$this->set('formData.id', $id);
		$this->set('formData.name', $name);
		$this->set('formData.permission', $permission);
		$this->set('formData.area', $isActive);
		$this->set('formData.updateAt', $updateAt);
	}
	
	/* Form submit action for edit
	 * @params: 
	 * @return: string
	 */
	public function getFormAction($formAction) : string
    {
		return match($formAction)
		{
			FormAction::CREATE => route('role.create.post'),
			FormAction::UPDATE => route('role.update.post'),
		};
	}
	
	/* 判別列表Role是否可編或可刪
	 * @params: 
	 * @return: boolean
	 */
	public function canUpdateThisRole($roleGroup)
	{
		return (RoleGroup::SUPERVISOR->value == $roleGroup) ? FALSE : TRUE; #super visor can not edit
	}
	
	public function canDeleteThisRole($roleGroup)
	{
		return (RoleGroup::SUPERVISOR->value == $roleGroup) ? FALSE : TRUE; #super visor can not edit
	}
	
	/* Output js */
	/*因與統計不同, 不使用trait response*/
	public function responseList()
	{
		$response['status'] 			= $this->status();
		$response['hasResult'] 			= ! empty($this->list);
		
		$response['data'] 				= $this->list;
		$response['supervisorGroupId']	= RoleGroup::SUPERVISOR->value;
		$response['createRoute']		= route('role.create');
		$response['updateRoute']		= route('role.update', ['id' => '_ID']);
		$response['deleteRoute']		= route('role.delete', ['id' => '_ID']);
		
		return $response;
	}
	
	public function responseDetail()
	{
		$response = $this->only('formData', 'options');
		
		$response['status'] 		= $this->status();
		$response['backRoute']		= route($this->backRoute);
		$response['formAction'] 	= $this->getFormAction($this->action);
		$response['actionLabel']	= ($this->action == FormAction::CREATE) ? '新增' : '儲存';
		
		return $response;
	}
}