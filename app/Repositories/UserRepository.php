<?php

namespace App\Repositories;

use App\Enums\RoleGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Exception;

class UserRepository extends Repository
{
	
	public function __construct()
	{
		
	}
	
	/* Get role list
	 * @params: 
	 * @return: array
	 */
	public function getActiveRoleList()
	{
		$db = $this->connectItPortal('role');
			
		$result = $db
			->select('roleId', 'roleName', 'rolePermission')
			->where('isActive', '=', TRUE)
			->where('roleGroupId', '=', RoleGroup::USER_DEFINED->value)
			->get();
		
		#處理Json type,若用each須傳&$row
		$result->transform(function($row) {
			$decoded = json_decode($row['rolePermission'], true);
			$row['rolePermission'] = $decoded ?? [];
			
			return $row;
		})->toArray();
		
		return $result;
	}
	
	/* Get user list by query conditions
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function getList()
	{
		$db = $this->connectItPortal('user as u');
			
		$result = $db->join('user_role as ur', 'ur.userId', '=', 'u.userId')
			->join('role as r', 'r.roleId', '=', 'ur.roleId')
			->leftJoin('access_log as l', 'l.userId', '=', 'u.userId')
			->where('r.roleGroupId', '=', RoleGroup::USER_DEFINED->value)
			->select('u.userId', 'u.userAccount', 'u.displayName', 'u.department', 'u.email', 'u.isActive')
			->addSelect('r.roleName', 'r.isActive as isRoleActive')
			->addSelect('l.updateAt as accessTime')
			->get()
			->toArray();
		
		return $result;
	}
	
	/* Get user by account
	 * @params: string
	 * @return: array
	 */
	public function getIdByAccount($account, $exceptId)
	{
		$db = $this->connectItPortal('user');
			
		$result = $db->select('userId')
					->where('userAccount', '=', $account)
					->when($exceptId, function($query, $exceptId){
						return $query->where('userId', '!=', $exceptId);
					})
					->get()
					->first();
		
		return data_get($result, 'userId', 0);
	}
	
	/* Create Account
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: boolean
	 */
	public function insert($account, $password, $displayName, $department, $email, $isActive, $roleId)
	{
		$db = $this->connectItPortal();
		$db->beginTransaction();
		
		try 
		{
			$insertId = $this->_insertUser($db, $account, $password, $displayName, $department, $email, $isActive);
			
			$this->_insertUserRole($db, $insertId, $roleId);
			
			$db->commit();

			return TRUE;
		} 
		catch (Exception $e) 
		{
			$db->rollBack();
			throw new Exception($e->getMessage());
		}
		
		return TRUE;
	}
	
	/* Create user
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: boolean
	 * @return: boolean
	 */
	private function _insertUser($db, $account, $password, $displayName, $department, $email, $isActive)
	{
		$data['userAccount']	= $account;
		$data['userPassword'] 	= $password;
		$data['displayName']	= $displayName;
		$data['department']		= $department;
		$data['email']			= $email;
		$data['isActive']		= $isActive;
		$data['createAt'] 		= now()->format('Y-m-d H:i:s');
		$data['updateAt'] 		= $data['createAt'];
		
		#$db = $this->connectItPortal();
		$insertId = $db->table('user')
			->insertGetId($data);
		
		return $insertId;
	}
	
	/* Create user
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: boolean
	 * @return: boolean
	 */
	private function _insertUserRole($db, $userId, $roleId)
	{
		$data['userId']		= $userId;
		$data['roleId'] 	= $roleId;
		
		#$db = $this->connectItPortal();
		$insertId = $db->table('user_role')
			->insert($data);
		
		return TRUE;
	}
	
	/* Get user by id
	 * @params: int
	 * @return: array
	 */
	public function getById($id)
	{
		$db = $this->connectItPortal('user as u');
		
		$result = $db->join('user_role as ur', 'ur.userId', '=', 'u.userId')
				->join('role as r', 'r.roleId', '=', 'ur.roleId')
				->where('u.userId', '=', $id)
				->select('u.userId', 'u.userAccount', 'u.displayName', 'u.department')
				->addSelect('u.email', 'u.isActive', 'u.updateAt')
				->addSelect('r.roleId', 'r.isActive as isRoleActive')
				->first();
		
		return $result;
	}
	
	/* Update user data by id
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: boolean
	 */
	public function update($id, $account, $password, $displayName, $department, $email, $isActive, $roleId)
	{
		$db = $this->connectItPortal();
		$db->beginTransaction();
		
		try 
		{
			$this->_updateUser($db, $id, $account, $password, $displayName, $department, $email, $isActive);
			
			$this->_updateUserRole($db, $id, $roleId);
			
			$db->commit();

			return TRUE;
		} 
		catch (Exception $e) 
		{
			$db->rollBack();
			throw new Exception($e->getMessage());
		}
		
		return TRUE;
	}
	
	/* Create user
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: boolean
	 * @return: boolean
	 */
	private function _updateUser($db, $id, $account, $password, $displayName, $department, $email, $isActive)
	{
		$data['userAccount']	= $account;
		
		if (! empty($password))
			$data['userPassword'] 	= $password;
		
		$data['displayName']	= $displayName;
		$data['department']		= $department;
		$data['email']			= $email;
		$data['isActive']		= $isActive;
		$data['updateAt'] 		= now()->format('Y-m-d H:i:s');
		
		$db->table('user')
			->where('userId', '=', $id)
			->update($data);
		
		return TRUE;
	}
	
	/* Create user
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: boolean
	 * @return: boolean
	 */
	private function _updateUserRole($db, $userId, $roleId)
	{
		$data['roleId']	= $roleId;
		
		$db->table('user_role')
			 ->where('userId', '=', $userId)
			 ->update($data);
		
		return TRUE;
	}
	
	/* Remove user by id
	 * @params: int
	 * @return: boolean
	 */
	public function remove($userId)
	{
		$db = $this->connectItPortal();
		$db->beginTransaction();
		
		try 
		{
			$db->table('user')
				->where('userId', '=', $userId)
				->delete();
			
			$db->table('user_role')
				->where('userId', '=', $userId)
				->delete();
				
			$db->commit();

			return TRUE;
		} 
		catch (Exception $e) 
		{
			$db->rollBack();
			throw new Exception($e->getMessage());
		}
		
		return TRUE;
	}
	
	/* Create user
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: string
	 * @return: boolean
	 */
	public function updateProfile($id, $password, $displayName, $department, $email)
	{
		if (! empty($password))
			$data['userPassword'] 	= $password;
		
		if (! empty($displayName))
			$data['userDisplayName']= $displayName;
		
		if (! empty($department))
			$data['department']	= $department;
		
		if (! empty($email))
			$data['email'] = $email;
		
		$data['updateAt'] = now()->format('Y-m-d H:i:s');
		
		$db = $this->connectSalesDashboard();
		
		$db->table('user')
			->where('userId', '=', $id)
			->update($data);
		
		return TRUE;
	}
}
