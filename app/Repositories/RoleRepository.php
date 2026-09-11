<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Exception;

class RoleRepository extends Repository
{
	
	public function __construct()
	{
		
	}
	/* Case-sensitive in ubuntu */
	/* Get role list from DB 
	 * @params: 
	 * @return: array
	 */
	public function getList()
	{
		$db = $this->connectItPortal('role');
			
		$result = $db
			->select('roleId', 'roleName', 'roleGroupId', 'rolePermission', 'isActive', 'updateAt')
			->get();
		
		#處理Json type,若用each須傳&$row
		$result->transform(function($row) {
			$decoded = json_decode($row['rolePermission'], true);
			$row['rolePermission'] = $decoded ?? [];
			
			return $row;
		});
		
		return $result;
	}
	
	/* Create Role
	 * @params: string
	 * @params: string
	 * @params: json string
	 * @params: json string
	 * @return: boolean
	 */
	public function insert($name, $groupId, $permission, $isActive)
	{
		$data['roleName']		= $name;
		$data['roleGroupId'] 	= $groupId;
		$data['rolePermission'] = json_encode($permission);
		$data['isActive'] 		= $isActive;
		$data['createAt'] 		= now()->format('Y-m-d H:i:s');
		$data['updateAt'] 		= $data['createAt'];
		
		$db = $this->connectItPortal('role');
		$id = $db->insertGetId($data);
		
		return TRUE;
	}
	
	/* Get Role Data
	 * @params: int
	 * @return: array
	 */
	public function getById($id)
	{
		$db = $this->connectItPortal('role');
			
		$result = $db->select('roleId', 'roleName', 'roleGroupId', 'rolePermission', 'isActive', 'updateAt')
					->where('roleId', '=', $id)
					->get()->first();
		
		
		$result['rolePermission'] 	= empty($result['rolePermission']) ? [] : json_decode($result['rolePermission'], TRUE);
			
		return $result;
	}
	
	/* Update Role
	 * @params: int
	 * @params: string
	 * @params: int
	 * @params: json string
	 * @params: json string
	 * @return: boolean
	 */
	public function update($id, $name, $permission, $isActive)
	{
		$data['roleName']		= $name;
		$data['rolePermission'] = json_encode($permission);
		$data['isActive'] 		= $isActive;
		$data['updateAt'] 		= now()->format('Y-m-d H:i:s');
		
		$db = $this->connectItPortal('role');
		$db->where('roleId', '=', $id)->update($data);
		
		return TRUE;
	}
	
	/* Remove Role
	 * @params: int
	 * @return: boolean
	 */
	public function remove($id)
	{
		$db = $this->connectItPortal('role');
		$db->where('roleId', '=', $id)->delete();
		
		return TRUE;
	}
}
