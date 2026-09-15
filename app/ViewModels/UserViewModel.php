<?php

namespace App\ViewModels;

use App\Services\UserService;
use App\Facades\AppManager;
use App\Enums\FormAction;
use App\Enums\OpCenter;
use App\Enums\Area;
use App\Enums\RoleGroup;
use App\Enums\Functions;
use App\ViewModels\Attributes\attrStatus;
use App\ViewModels\Attributes\attrActionBar;
use App\ViewModels\Attributes\attrAllowAction;
use Illuminate\Support\Fluent;

class UserViewModel extends Fluent
{
	use attrStatus, attrActionBar, attrAllowAction;
	
	public function __construct(protected UserService $_service)
	{
		$this->function		= Functions::USER;
		$this->action 		= FormAction::LIST; 
		$this->backRoute 	= 'users';
		$this->success();
	}
	
	/* initialize
	 * @params: enum
	 * @return: void
	 */
	public function initialize($action)
	{
		#初始化各參數及Form Options
		$this->action	= $action;
		$this->success();
		
		$this->_setOptions();
	}
	
	/* Form所屬的參數選項
	 * @params:  
	 * @return: void
	 */
	private function _setOptions()
	{
		$this->set('options.roleList', $this->_service->getActiveRoleList());
		$this->set('options.supervisorGroupId', RoleGroup::SUPERVISOR->value); 
	}
	
	/* Form submit action
	 * @params: 
	 * @return: string
	 */
	public function getFormAction($formAction) : string
    {
		return match($formAction)
		{
			FormAction::CREATE => route('user.create.post'),
			FormAction::UPDATE => route('user.update.post'),
		};
	}
	
	/* Keep user form data
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: void
	 */
	public function keepFormData($id = 0, $account = '',  $password = '',
						$displayName = '', $department = '', $email = '', $isActive = TRUE, 
						$roleId = 0, $updateAt = '')
    {
		#info
		$this->set('formData.id', $id);
		$this->set('formData.account', $account);
		$this->set('formData.password', $password);
		$this->set('formData.displayName', $displayName);
		$this->set('formData.department', $department);
		$this->set('formData.email', $email);
		$this->set('formData.isActive', $isActive);
		$this->set('formData.roleId', $roleId);
		$this->set('formData.updateAt', $updateAt);
	}
	
	
	/* Output js */
	/*因與統計不同, 不使用trait response*/
	public function responseList()
	{
		$response['data'] = $this->list;
		
		$response['response']['status'] 		= $this->status();
		$response['response']['hasResult'] 		= ! empty($this->list);
		$response['response']['createRoute']	= route('user.create');
		$response['response']['updateRoute']	= route('user.update', ['id' => '_ID']);
		$response['response']['deleteRoute']	= route('user.delete', ['id' => '_ID']);
		
		return $response;
	}
	
	public function responseDetail()
	{
		$response = $this->only('formData', 'options');
		
		$response['response']['status'] 		= $this->status();
		$response['response']['backRoute']		= route($this->backRoute);
		$response['response']['formAction'] 	= $this->getFormAction($this->action);
		$response['response']['actionLabel']	= ($this->action == FormAction::CREATE) ? '新增' : '儲存';
		
		return $response;
	}
}