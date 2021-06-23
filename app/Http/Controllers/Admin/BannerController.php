<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\MediumBanner;
use App\Model\Product\Category;
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
        foreach ($banner as $ban) {
            $image = explode(';',$ban->media_url);
            $ban->media_url = $image;
            $image_mobile = explode(';',$ban->media_url_mobile);
            $ban->media_url_mobile = $image_mobile;
        }
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
        $pageNames = ['Index','productList','productDetail','FAQ','News','Infomation','AboutUs','ContactUs','HomeSolution','OfficeSolution'];
        $categories = Category::select(['id','name','parent_id'])->where('is_active',1)->get();
        foreach ($categories as $category) {
            if ($category->parent_id == 0) {
                $pageNames[] = $category->name;
                foreach ($categories as $catego) {
                    if ($catego->parent_id == $category->id) {
                        $pageNames[] = $catego->name;
                    }
                }
            }
        }
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
        $images = '';
        if (!empty($data['media_url'])) {
            foreach ($data['media_url'] as $image) {
                $images = ($images == '') ? $image : $images.';'.$image;
            }
        }
        $images_mobile = '';
        if (!empty($data['media_url_mobile'])) {
            foreach ($data['media_url_mobile'] as $image_mobile) {
                $images_mobile = ($images_mobile == '') ? $image_mobile : $images_mobile.';'.$image_mobile;
            }
        }
        try {
            MediumBanner::create([
                'page_name' => $data['page_name'],
                'media_url' => $images,
                'banner_alt' => $data['banner_alt'],
                'media_url_mobile' => $images_mobile,
                'banner_alt_mobile' => $data['banner_alt_mobile'],
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
        if (isset($banner->media_url) && $banner->media_url != '') {
            $image = explode(';',$banner->media_url);
            $banner->media_url = $image;
        }
        if (isset($banner->media_url) && $banner->media_url != '') {
            $image_mobile = explode(';',$banner->media_url_mobile);
            $banner->media_url_mobile = $image_mobile;
        }
        return view('admin.banner.edit',compact('pageNames','id','banner'));
    }

    public function update(Request $request,$id)
    {
        $data = $request->only(['page_name','media_url','is_active','description','banner_alt','media_url_mobile','banner_alt_mobile']);
        $medis_url = '';
        if (!empty($data['media_url'])) {
            foreach ($data['media_url'] as $media) {
                $medis_url = ($medis_url == '') ? $media : $medis_url.';'.$media;
            }
        }
        $data['media_url'] = $medis_url;
        $medis_url_mobile = '';
        if (!empty($data['media_url_mobile'])) {
            foreach ($data['media_url_mobile'] as $media_mobile) {
                $medis_url_mobile = ($medis_url_mobile == '') ? $media_mobile : $medis_url_mobile.';'.$media_mobile;
            }
        }
        $data['media_url_mobile'] = $medis_url_mobile;
        try {
            $banner = MediumBanner::findOrFail($id);
            $banner->update($data);
            return Redirect::to(URL::route('admin.banner.index'))->with(['success' => '更新成功']);
        } catch (\Exception $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }
    }
}
