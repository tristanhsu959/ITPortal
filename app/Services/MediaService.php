<?php

namespace App\Services;

use App\Facades\AppManager;
use App\Repositories\MediaRepository;
use App\Libraries\ResponseLib;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Exception;
use Log;

class MediaService
{
	private $_logChannel = 'apiMediaLog';
	
	public function __construct(protected MediaRepository $_repository)
	{
	}
	
	/* 取身份清單(Get active)
	 * @params: 
	 * @return: array
	 */
	public function getActiveRoleList()
	{
		try
		{
			$list = $this->_repository->getActiveRoleList();
			
			return $list;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return [];
		}
	}
	
	/* 取帳號清單(Get ALL)
	 * @params: 
	 * @return: array
	 */
	public function getList()
	{
		try
		{
			$list = $this->_repository->getList();
			
			return ResponseLib::initialize($list)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('讀取帳號清單時發生錯誤');
		}
	}
	
	/* Create Account
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function create($request)
	{
		try
		{
			#1.Save media file
			$this->_processMediaFile($request);
			
			#2.Insert to db
			$request->id = $this->_repository->insert($request);
			
			#3.Build response
			$metaData = $this->_buildMetaData($request->id, $request->mediaName, $request->path, $request->stDate, $request->endDate, $request->type, $request->enabled);
			
			#4.Return response
			$response = ResponseLib::initialize($metaData)->success()->get();
			
			$this->_log->response = $response;
			Log::channel($this->_logChannel)->info('media.create', $this->_log->toArray());
			
			return $response;
		}
		catch(Exception $e)
		{
			$this->_removeMedia($request->id, $request->path);
			
			#Api要call get()直接回傳
			$response = ResponseLib::initialize()->fail('媒體庫新增失敗')->get(); 
			
			$this->_log->response = $response;
			Log::channel($this->_logChannel)->error('media.create', $this->_log->toArray());
			Log::channel($this->_logChannel)->error('media.create[exception]', [$e->getMessage()]);
			
			return $response;
		}
		
		try
		{
			#1.Check account
			if ($this->_isAccountExist($account) === TRUE)
				throw new Exception('此帳號已存在');
			
			#2.Hash password
			$password = Hash::make($password);
			
			#3. Create user
			$this->_repository->insert($account, $password, $displayName, $department, $email, $isActive, $roleId);
		
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* 驗證帳號
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	private function _isAccountExist($account, $exceptId = FALSE)
	{
		try
		{
			$id = $this->_repository->getIdByAccount($account, $exceptId); 
			
			return empty($id) ? FALSE : TRUE;
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			throw new Exception('驗證帳號發生錯誤');
		}
	}
	
	/* Update:取User Data
	 * @params: int
	 * @return: array
	 */
	public function getUserById($id)
	{
		try
		{
			$result = $this->_repository->getById($id);
			
			return ResponseLib::initialize($result)->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('讀取帳號資料發生錯誤');
		}
	}
	
	/* Update User
	 * @params: int
	 * @params: string
	 * @params: string
	 * @params: int
	 * @return: array
	 */
	public function updateUser($id, $account, $password, $displayName, $department, $email, $isActive, $roleId)
	{
		try
		{
			#1.Check account
			if ($this->_isAccountExist($account, $id) === TRUE)
				throw new Exception('此帳號已存在');
			
			#2.Hash password
			if (! empty($password))
				$password = Hash::make($password);
			
			#4. Update user
			$this->_repository->update($id, $account, $password, $displayName, $department, $email, $isActive, $roleId);
			
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}
	
	/* Remove User
	 * @params: int
	 * @return: array
	 */
	public function deleteUser($id)
	{
		try
		{
			$this->_repository->remove($id);
			
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail('刪除帳號失敗');
		}
	}
	
	/* User profile update
	 * @params: int 
	 * @params: string
	 * @params: string
	 * @params: string
	 * @params: string
	 * @return: array
	 */
	public function updateProfile($id, $password, $displayName, $department, $email)
	{
		try
		{
			$password = empty($password) ? $password : Hash::make($password);
			$this->_repository->updateProfile($id, $password, $displayName, $department, $email);
			
			#更新同步
			$user = $this->_repository->getById($id);
			AppManager::updateCurrentUserProfile($user['userDisplayName'], $user['department'], $user['email']);
			
			return ResponseLib::initialize()->success();
		}
		catch(Exception $e)
		{
			Log::channel('appServiceLog')->error($e->getMessage(), [ __class__, __function__, __line__]);
			return ResponseLib::initialize()->fail($e->getMessage());
		}
	}

	/* ====================== Common ====================== */
	
	/* File save for create or update
	 * @params: fluent
	 * @return: array
	 */
	private function _processMediaFile($request)
	{
		#壓縮圖檔需安裝:composer require intervention/image
		#目前只有新增,編輯無
		#extension():mime type / guessClientExtension():client副檔名
		
		if ($request->type == MediaType::IMAGE->value && $request->uploadFile->isValid())
		{
			#1920 × 1080
			$image = Image::read($request->uploadFile->getRealPath());
			$image->scale(width: 1920);
			
			$jpg	= $image->toJpeg(50);
			$webp 	= $image->toWebp(50); #default quality is 75
			
			#用同檔名,就無須存DB
			$fileName = Str::uuid();
			$request->path = "{$fileName}.jpg";
			$webpPath = "webp/{$fileName}.webp";
			
			Storage::disk('tvMenu')->put($request->path, (string)$jpg); #put, putFile are different
			Storage::disk('tvMenu')->put($webpPath, (string)$webp); #put, putFile are different
		}
		else if ($request->type == MediaType::VIDEO->value)
			$request->path = $request->uploadLink;
		else
			throw new Exception('無法識別媒體類型');
		
		unset($request->uploadFile);
		unset($request->uploadLink);
	}
	
	/* Build response data for return
	 * @params: 
	 * @return: array
	 */
	private function _buildMetaData($id = 0, $mediaName = '', $path = '', $stDate = NULL, $endDate = NULL, $type = 0, $enabled = TRUE)
	{
		#正規化Media output
		$data['id'] 		= intval($id);
		$data['mediaName'] 	= $mediaName;
		
		if ($type == MediaType::IMAGE->value)
		{
			$webpPath = Str::of('webp/')->append(Str::replaceEnd('jpg', 'webp', $path));
			
			$data['mediaUrl']	= Storage::disk('tvMenu')->url($path);
			$data['webpUrl']	= Storage::disk('tvMenu')->url($webpPath);
		}
		else
			$data['mediaUrl']	= $path;
		
		$data['stDate'] 	= $stDate;
		$data['endDate'] 	= $endDate;
		$data['type'] 		= $type;
		$data['typeName'] 	= MediaType::tryFrom($type)->label();
		$data['enabled'] 	= boolval($enabled);
		
		return $data;
	}
	
	/* Remove file
	 * @params: fluent
	 * @return: array
	 */
	private function _removeMedia($id, $fileName)
	{
		if (! empty($id))
			$this->_repository->remove($id);
		
		if (! empty($fileName))
		{
			if (Storage::disk('tvMenu')->exists($fileName))
				Storage::disk('tvMenu')->delete($fileName);
		}
		
		return TRUE;
	}
}
