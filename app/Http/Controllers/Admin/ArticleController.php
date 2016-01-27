<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use App\Article;

class ArticleController extends Controller
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
        return view('admin.article.index');
    }

    /**
     * article datas.
     *
     * @return \Illuminate\Http\Response
     */
    public function datas()
    {
        return Datatables::of(Article::select('*'))->make(true);
    }

    /**
     * article update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        Article::where('id', $id)->update($data);

        return response()->json(['message' => '更新成功'], 201);
    }

    /**
     * article store.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // dd($data);
        Article::create($data);

        return response()->json(['message' => '添加成功'], 201);
    }

    /**
     * article edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Log::info('Showing user profile for user: '.$id);

        return response()->json(Article::findOrFail($id));
    }

    /**
     * article destroy.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Log::info('Showing user profile for user: '.$id);

        return response()->json(Article::destroy($id));
    }
}
