<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Sitemap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class SiteMapController extends AdminController
{
    public function index()
    {
        $type = Sitemap::select(['name'])->groupBy('name')->get();
        return view('admin.siteMap.index',compact('type'));
    }

    public function getList(Request $request)
    {
        $where = [];
        if ($name = $request->name) {
            $where['name'] = $name;
        }
        $siteMap = Sitemap::where($where)->paginate($request->get('limit',90));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $siteMap->total(),
            'data' => $siteMap->items()
        ];
        return Response::json($data);
    }

    public function edit($id)
    {
        $siteMap = Sitemap::findOrFail($id);
        return view('admin.siteMap.edit',compact('siteMap'));
    }

    public function update(Request $request)
    {
        if (empty($request->id)) return redirect::back()->withErrors('参数错误，缺少ID');
        $siteMap = Sitemap::findOrFail($request->id);
        $data = $request->only(['url']);
        try {
            $siteMap->update($data);
            return Redirect::to(URL::route('admin.site.map.index'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
