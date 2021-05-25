<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\MediumBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class BannerController extends AdminController
{
    public function index()
    {
        return view('admin.banner.index');
    }

    public function getList(Request $request)
    {
        $banner = MediumBanner::paginate($request->get('limit',30));
        $data = [
            'code' => 0,
            'msg' => 'loading....',
            'count' => $banner->total(),
            'data' => $banner->items()
        ];
        return Response::json($data);
    }

    public function getPageName()
    {
        $pageNames = [
            'Index','productList','FAQ','News','Infomation','AboutUs','ContactUs','Solution',
        ];
        return $pageNames;
    }

    public function create()
    {
        $pageNames = $this->getPageName();
        return view('admin.banner.create',compact('pageNames'));
    }

    public function addBanner(Request $request)
    {
        $data = $request->all();
        try {
            MediumBanner::create([
                'page_name' => $data['page_name'],
                'media_url' => $data['media_url'],
                'is_active' => $data['is_active'],
                'description' => $data['description'],
            ]);
            return Redirect::to(URL::route('admin.banner.index'))->with(['success'=>'添加成功']);
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
            return redirect::back()->withErrors('添加失败: ' . $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $pageNames = $this->getPageName();
        $banner = MediumBanner::findOrFail($id);
        return view('admin.banner.edit',compact('pageNames','id','banner'));
    }

    public function update(Request $request,$id)
    {
        $data = $request->only(['page_name','media_url','is_active','description']);
        try {
            $banner = MediumBanner::findOrFail($id);
            $banner->update($data);
            return Redirect::to(URL::route('admin.banner.index'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
