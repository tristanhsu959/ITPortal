<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ViewModels\HomeViewModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	private $_service;
	private $_currentAction = NULL;
	
	public function __construct(protected HomeViewModel $_viewModel)
	{
	}
	
	public function index(Request $request)
	{
		// $a = [
			// "porkRibs"=>[2],
			// "tomatoBeef"=>[2],
			// "users"=>[1, 2, 3, 4],
			// "roles"=>[1, 2, 3, 4],
		// ];
		#{"porkRibs":[2],"tomatoBeef":[2],"users":[1,2,3,4],"roles":[1,2,3,4]}
		# ["1","2","3","4","5","6"]
		
		// dd(json_encode($a));
		return view('home')->with('viewModel', $this->_viewModel);
	}
	
}