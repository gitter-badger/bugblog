<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use App\Cat;

class CatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cat.index');
    }

    /**
     * Cat datas.
     *
     * @return \Illuminate\Http\Response
     */
    public function datas()
    {
        return Datatables::of(Cat::select('*'))->make(true);
    }

    /**
     * Cat update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        Cat::where('id', $id)->update($data);

        return response()->json(['message' => '更新成功'], 201);
    }

    /**
     * Cat store.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // dd($data);
        Cat::create($data);

        return response()->json(['message' => '添加成功'], 201);
    }

    /**
     * Cat edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Log::info('Showing user profile for user: '.$id);

        return response()->json(Cat::findOrFail($id));
    }

    /**
     * Cat destroy.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Log::info('Showing user profile for user: '.$id);

        return response()->json(Cat::destroy($id));
    }
}
