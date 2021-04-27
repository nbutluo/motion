<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Contact;
use Illuminate\Http\Request;

class ContactUsController extends AdminController
{
    protected $contactModel;

    public function __construct(Contact $contactModel)
    {
        //parent::__construct();
        $this->contactModel = $contactModel;
    }

    public function index()
    {
        $list = Contact::orderBy('id', 'asc')->get();
        return view('admin.contact.index', compact('list'));
    }

    public function getList(Request $request)
    {

//        getSqlLog();

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $where = [];
        if ($email = $request->input('email')) {
            $where['email'] = $email;
        }
        if ($name = $request->input('name')) {
            $where['name'] = $name;
        }

        $res = $this->contactModel->getPageList($page, $limit, $where);

        return response()->json([
            'code' => 0,
            'msg' => '获取成功',
            'count' => $res['total'],
            'data' => $res['list'],
        ]);
    }

    public function detail($id)
    {
        $contact = Contact::findOrFail($id);

        return view('admin.contact.detail', compact('contact'));
    }
}
