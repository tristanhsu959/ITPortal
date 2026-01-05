<?php

namespace App\ViewModels\Traits;

use App\Enums\FormAction;

#Breadcrumb | backurl
trait ActionBarTrait
{
	/* Set status & msg
	 * @params: string
	 * @return: void
	 */
	public function breadcrumb()
	{
		$breadcrumb 	= [];
		$action 		= data_get($this->_data, 'action', '');
		
		$breadcrumb[] 	= $this->_title;
		$actionName = $action->label();
		
		if (empty($actionName))
			return $breadcrumb;
		
		$breadcrumb[] = $actionName;
		
		return $breadcrumb;
	}
	
	public function backRoute()
	{
		$action = data_get($this->_data, 'action', '');
		
		if ($action != FormAction::SIGNIN && $action != FormAction::HOME
				&& $action != FormAction::List)
			return $this->_backRoute;
		else
			return '';
	}
}