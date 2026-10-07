<?php

namespace App\View\Components;

use App\Facades\AppManager;
use App\Enums\Area;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class Profile extends Component
{
	 /**
     * Create a new component instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
		$profile = $this->_getProfile();
		
        return view('components.profile', ['currentUser' => $profile]);
    }
	
	private function _getProfile()
	{
		/* [
			"id" => 1
			"account" => "tristan.hsu"
			"displayName" => "Tristan"
			"department" => "資訊處"
			"email" => "tristan.hsu@8way.com.tw"
			"roleName" => "Supervisor"
			"roleGroupId" => 1
			"rolePermission" => array:33 [
			  0 => "home"
			  1 => "user"
			  2 => "role"
		] */
	
		$data = [];
		$data['profile'] = AppManager::getCurrentUser();
		$data['options']['signoutRoute'] = route('signout');
		$data['options']['updateRoute'] = route('profile.update.post');
		
		unset($data['profile']['roleGroupId']);
		unset($data['profile']['rolePermission']);
		
		return $data;
	}
}
