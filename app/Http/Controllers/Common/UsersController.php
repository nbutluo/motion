<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Level;
use App\Models\Apply;

class UsersController extends Controller
{

    public function index(User $user, Level $level)
    {
        $users = User::paginate(10);
        $levels = Level::get();
        $counts = $user->count();
        $activateds = $user->activateds();
        $inactivateds = $user->inactivateds();
        return view('admin.users.index', compact('users', 'levels', 'counts', 'activateds', 'inactivateds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        foreach ($user->apply as  $apply) {
            if (!$apply['is_audit']) {
                $user['apply_id'] = $apply['id'];
                $user['apply_code'] = 1;
                $user['apply_reason'] = $apply['apply_reason'];
            }
        }
        return view('admin.users.edit', compact('user'));
    }


    // 更新 level 与 apply_status，同时更新 applies 中 id 对应的 is_audit
    public function update(Request $request, User $user, Apply $apply)
    {
        // 更新用户 level
        $user->level = $request->level;
        // 更新用户 apply_status 为 0 表示申请中
        $user->apply_status = 0;
        $user->update();

        // 更新 applies 表 已审核
        $apply->where('id', $request->apply_id)->update(['is_audit' => 1]);
        return redirect()->route('user.index')->with('success', '更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
