<?php

namespace App\ViewModels;

use App\Enums\FormAction;
use App\ViewModels\Traits\StatusTrait;

class SigninViewModel
{
	use StatusTrait;
	
	private $_service;
	private $_title = '登入';
	private $_data = [];
	
	public function __construct()
	{
		#Base data
		$this->_data['action'] 		= NULL; #enum form action
		$this->success();	#default
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
	
	/* initialize
	 * @params: enum
	 * @return: void
	 */
	public function initialize($action)
	{
		#初始化各參數及Form Options
		$this->_data['action']	= $action;
	}
	
	/* Keep signin form data : account only, 以防會使用到
	 * @params: string
	 * @return: void
	 */
	public function keepFormData($adAccount)
    {
		data_set($this->_data, 'adAccount', $adAccount);
	}
	
	        
}