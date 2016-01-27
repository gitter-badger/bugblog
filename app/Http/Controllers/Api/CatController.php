<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cat;

class CatController extends Controller
{
	/**
	 * 获取所有分类
	 */
    public function allCats(Request $request)
    {
    	$params = $request->get('q');

    	$datas = Cat::select(['id', 'title'])
    		->where('title', 'like', '%'.$params.'%')->get();

    	return response()->json($datas);
    }
}
