<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OrderPosService;
use App\ViewModels\OrderPosViewModel;
use App\Enums\FormAction;
use App\Enums\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OrderPosController extends Controller
{
	
	public function __construct(protected OrderPosService $_service, protected OrderPosViewModel $_viewModel)
	{
	}
	
	public function showSearch(Request $request)
	{
		$this->_viewModel->initialize();
		$this->_viewModel->keepSearchData();
		
		return view('order.pos')->with('viewModel', $this->_viewModel);
	}
	
	/* Search
	 * @params: request
	 * @return: view
	 */
	public function search(Request $request)
	{
		$brand 		= $this->_service->parsingBrand($request->segments());
		$function 	= $this->_service->parsingFunction($brand);
		
		$searchType			= $request->input('searchType');
		$searchStDate		= $request->input('searchStDate');
		$searchEndDate		= $request->input('searchEndDate');
		$searchAreaIds		= $request->array('searchAreaIds');
		$searchStoreName	= $request->input('searchStoreName', NULL);
		$searchCategory		= $request->input('searchCategory');
		$searchProductIds	= $request->array('searchProductIds');
		
		$this->_viewModel->initialize($brand, $function);
		$this->_viewModel->keepSearchData($searchType, $searchStDate, $searchEndDate, $searchAreaIds, $searchStoreName, $searchCategory, $searchProductIds);
		
		$response = $this->_service->getStatistics($brand, $searchType, $searchStDate, $searchEndDate, $searchAreaIds, $searchStoreName, $searchCategory, $searchProductIds);
		
		if ($response->status === FALSE)
			$this->_viewModel->fail($response->msg);
		else
			$this->_viewModel->success();
		
		$this->_viewModel->statistics = $response->data; #失敗也要有預設值
		
		return view('sales.statistics')->with('viewModel', $this->_viewModel);
	}
}
