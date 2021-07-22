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

    public function frontPackage()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, 'http://52.156.128.157:3000/');
            $file_contents = curl_exec($ch);
            curl_close($ch);

            file_put_contents(storage_path('logs/package.log'), 'date :  ' .  date('Y-m-d H:i:s') . '  msg: '.$file_contents. PHP_EOL, FILE_APPEND);
            return $file_contents;
        } catch (\Exception $exception) {
            file_put_contents(storage_path('logs/package.log'), 'date :  ' .  date('Y-m-d H:i:s') . '  code : 400' .'msg: '.$exception->getMessage() . PHP_EOL, FILE_APPEND);
            return '400';
        }
    }
}
