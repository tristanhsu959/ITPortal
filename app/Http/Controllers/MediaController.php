<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use App\ViewModels\MediaViewModel;
use App\Enums\FormAction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
	
	public function __construct(protected MediaService $_service, protected MediaViewModel $_viewModel)
	{
	}
	
	/* 列表
	 * @params: request
	 * @return: view
	 */
	public function list(Request $request)
	{
		$this->_viewModel->initialize();
		
		$response = $this->_service->getList();
		
		if ($response->status === FALSE)
			$this->_viewModel->fail($response->msg);
		else
		{
			$this->_viewModel->success();
			$this->_viewModel->list = $response->data;
		}
		
		return view('tv_media/list')->with('viewModel', $this->_viewModel);
	}
	
	/* 新增Form
	 * @params: request
	 * @return: view
	 */
	public function showCreate(Request $request)
	{
		#initialize
		$this->_viewModel->initialize(FormAction::CREATE);
		$this->_viewModel->keepFormData(); #init
		$this->_viewModel->success();
		
		return view('tv_media/detail')->with('viewModel', $this->_viewModel);
	}
	
	/* 新增 POST
	 * @params: request
	 * @return: view
	 */
	public function create(Request $request)
	{
		$type		= $request->input('type');
		$name		= $request->input('name');
		$uploadFile	= $request->file('uploadFile');
		$uploadLink	= $request->input('uploadLink');
		$stDate		= $request->input('stDate');
		$endDate	= $request->input('endDate');
		$isActive	= $request->boolean('isActive');
		
		#initialize
		$mediaUrl = '';
		$this->_viewModel->initialize(FormAction::CREATE);
		$this->_viewModel->keepFormData(0, $type, $name, $mediaUrl, $stDate, $endDate, $isActive, $uploadFile, $uploadLink);
		
		#validate input
		$validator = Validator::make($request->all(), [
            'type' 			=> 'required',
			'name' 			=> 'required',
			'uploadFile'	=> 'required_if:type,image',
			'uploadLink'	=> 'required_if:type,link',
        ]);
 
        if ($validator->fails()) 
		{
			$this->_viewModel->fail('資料輸入不完整或格式錯誤');
			return view('tv_media/detail')->with('viewModel', $this->_viewModel);
		}
		
		$request = $this->_viewModel->formData;
		dd($request);
		$response = $this->_service->createMedia($type, $name, $mediaUrl, $stDate, $endDate, $isActive, $uploadFile, $uploadLink);
		
		if ($response->status === FALSE)
		{
			$this->_viewModel->fail($response->msg);
			return view('tv_media/detail')->with('viewModel', $this->_viewModel);
		}
		else
			return redirect()->route('tv_media.list')->with('msg', '新增帳號完成');
	}
	
	/* 編輯Form
	 * @params: request
	 * @params: int	id
	 * @return: view
	 */
	public function showUpdate(Request $request, $id)
	{
		#initialize
		$this->_viewModel->initialize(FormAction::UPDATE);
		
		if (empty($id))
			return redirect()->route('user.list')->with('msg', '帳號識別ID為空值');
		
		$response = $this->_service->getUserById($id);
		
		if ($response->status === FALSE)
			return redirect()->route('user.list')->with('msg', $response->msg);
		
		$data = $response->data;
		
		$this->_viewModel->keepFormData($data['userId'], $data['userAccount'], '', $data['displayName'],
								$data['department'], $data['email'], $data['isActive'], 
								$data['roleId'], $data['updateAt']);
		
		$this->_viewModel->success();
		
		return view('user/detail')->with('viewModel', $this->_viewModel);
	}
	
	/* 編輯Form
	 * @params: request
	 * @return: view
	 */
	public function update(Request $request)
	{
		$id				= $request->input('id');
		$displayName	= $request->input('displayName');
		$department		= $request->input('department');
		$roleId			= $request->integer('roleId');
		$account		= $request->input('account');
		$password		= $request->input('password');
		$email			= $request->input('email');
		$isActive		= $request->boolean('isActive');
		
		#initialize
		$this->_viewModel->initialize(FormAction::UPDATE);
		$this->_viewModel->keepFormData($id, $account, $password, $displayName,
											$department, $email, $isActive, $roleId);
		
		#validate input
		$validator = Validator::make($request->all(), [
			'id'		=> 'required',
            'account' 	=> 'required|max:20',
			'email' 	=> 'required|email', 
			'roleId'	=> 'required', 
        ]);
 
		if ($validator->fails()) 
		{
			$this->_viewModel->fail('資料輸入不完整或格式錯誤');
			return view('user/detail')->with('viewModel', $this->_viewModel);
		}
		
		$response = $this->_service->updateUser($id, $account, $password, $displayName, $department, $email, $isActive, $roleId);
		
		if ($response->status === FALSE)
		{
			$this->_viewModel->fail($response->msg);
			return view('user/detail')->with('viewModel', $this->_viewModel);
		}
		else
			return redirect()->route('user.list')->with('msg', '編輯帳號完成');
	}
	
	/* 刪除
	 * @params: request
	 * @params: int	id
	 * @return: view
	 */
	public function delete(Request $request, $id)
	{
		#initialize
		$this->_viewModel->initialize(FormAction::DELETE);
		
		/*跟validator整併即可*/
		if (empty($id))
			return redirect()->route('user.list')->with('msg', '帳號識別ID為空值');
		
		$response = $this->_service->deleteUser($id);
		
		if ($response->status === FALSE)
			return redirect()->route('user.list')->with('msg', $response->msg);
		else
			return redirect()->route('user.list')->with('msg', '刪除帳號完成');
	}
}
