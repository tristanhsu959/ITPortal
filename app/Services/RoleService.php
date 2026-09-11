<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Libraries\ResponseLib;
use App\Enums\RoleGroup;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Exception;
use Log;

class RoleService
{
	
	public function __construct(protected RoleRepository $_repository)
	{
	}
	
	/* 取Role清單(Get ALL)
	 * @params: 
	 * @return: array
	 */
	public function getList()
	{
		try
		{
			$list = $this->_repository->getList();
			
			return ResponseLib::initialize($list->toArray())->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('讀取身份清單時發生錯誤');
		}
	}
	
	/* 取Role清單(Get enables)
	 * @params: 
	 * @return: array
	 */
	public function getEnableList()
	{
		try
		{
			$list = $this->_repository->getList();
			
			#不顯示內建Role
			$list = $list->reject(function($item, $key){
				return $item['roleGroupId'] == RoleGroup::SUPERVISOR->value;
			})->toArray();
			
			return ResponseLib::initialize($list)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('讀取帳號清單時發生錯誤');
		}
	}
	
	/* Create role
	 * @params: string
	 * @params: int
	 * @params: array
	 * @params: array
	 * @return: array
	 */
	public function createRole($name, $permission, $isActive)
	{
		try
		{
			$groupId = RoleGroup::USER_DEFINED->value; #default always
			$permission = empty($permission) ? [] : $permission; #以防萬一
			
			$this->_repository->insert($name, $groupId, $permission, $isActive);
		
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('新增身份失敗');
		}
	}
	
	/* Get role by id
	 * @params: int
	 * @return: array
	 */
	public function getRoleById($id)
	{
		try
		{
			$result = $this->_repository->getById($id);
			
			return ResponseLib::initialize($result)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('讀取身份設定時發生錯誤');
		}
	}
	
	/* Update Role
	 * @params: int
	 * @params: string
	 * @params: int
	 * @params: array
	 * @params: array
	 * @return: array
	 */
	public function updateRole($id, $name, $permission, $isActive)
	{
		try
		{
			$permission = empty($permission) ? [] : $permission;
			
			$this->_repository->update($id, $name, $permission, $isActive);
		
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('編輯身份失敗');
		}
	}
	
	/* Remove Role
	 * @params: int
	 * @return: array
	 */
	public function deleteRole($id)
	{
		try
		{
			$this->_repository->remove($id);
			
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('刪除身份失敗');
		}
	}
	
}
