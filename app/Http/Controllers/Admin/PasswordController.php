<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PasswordController extends Controller
{
    public function changeMyPasswordForm()
    {
        return view('admin.user.changeMyPassword');
    }

    public function changeMyPassword(Request $request)
    {
        if (!Hash::check($request['old_password'],auth()->user()->password)) {
            return Redirect::back()->withErrors('your password is wrong!');
        }
        try {
            $user = auth()->user();
            $user->password = bcrypt($request['new_password']);
            $user->save();
            return Redirect::back()->with(['success' => 'Password reset complete']);
        } catch(\Exception $exception) {
            return Redirect::back()->witherrors('Password reset failed');
        }
    }
}
