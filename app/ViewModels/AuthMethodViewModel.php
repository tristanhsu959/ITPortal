<?php

namespace App\ViewModels;

use App\Facades\AppManager;
use App\Enums\FormAction;
use App\Enums\Functions;
use App\ViewModels\Attributes\attrStatus;
use App\ViewModels\Attributes\attrActionBar;
use App\ViewModels\Attributes\attrAllowAction;
use Illuminate\Support\Fluent;

class AuthMethodViewModel extends Fluent
{
	use attrStatus, attrActionBar, attrAllowAction;
	
	public function __construct()
	{
		$this->function		= Functions::AUTH_METHOD;
		$this->action 		= FormAction::LIST; 
		$this->backRoute 	= '';
		$this->success();
	}
	
	/* initialize
	 * @params: enum
	 * @return: void
	 */
	public function initialize($action = FormAction::LIST)
	{
		#初始化各參數及Form Options
		$this->action	= $action;
		$this->success();
		$this->_setOptions();
	}
	
	/* Form參數選項
	 * @params:  
	 * @return: void
	 */
	private function _setOptions()
	{
		$types = [
			'image'	=> '圖檔',
			'link'	=> '影片連結'
		];
		
		$this->set('options.types', $types);
	}
	
	/* Form submit action
	 * @params: 
	 * @return: string
	 */
	public function getFormAction($formAction) : string
    {
		return match($formAction)
		{
			/* FormAction::CREATE => route('media.create.post'),
			FormAction::UPDATE => route('media.update.post'), */
		};
	}
	
	/* Keep form data
	 * @params: int
	 * @params: string [image|link]
	 * @return: void
	 */
	public function keepFormData($id = 0, $type = 'image', $name = '', $mediaUrl = '', $stDate = NULL, $endDate = NULL, $isActive = TRUE, 
									$uploadFile = '', $uploadLink = '')
    {
		$this->set('formData.id', $id);
		$this->set('formData.type', $type);
		$this->set('formData.name', $name);
		$this->set('formData.uploadFile', ''); #always empty
		$this->set('formData.uploadLink', $uploadLink);
		$this->set('formData.stDate', $stDate);
		$this->set('formData.endDate', $endDate);
		$this->set('formData.isActive', $isActive);
		$this->set('formData.mediaUrl', $mediaUrl);
	}
	
	
	/* Output js */
	/*因與統計不同, 不使用trait response*/
	public function responseList()
	{
		$response['data'] = $this->list;
		
		$response['response']['status'] 		= $this->status();
		$response['response']['hasResult'] 		= ! empty($this->list);
		/* $response['response']['createRoute']	= route('media.create');
		$response['response']['updateRoute']	= route('media.update', ['id' => '_ID']);
		$response['response']['deleteRoute']	= route('media.delete', ['id' => '_ID']); */
		
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