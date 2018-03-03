<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
class SessionController extends Controller
{
    public function create()
    {
        return view('session.create');
    }
    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required|'
        ]);
        if (Auth::attempt($credentials,$request->has('remember'))){
            //登陆成功
            session()->flash('success','欢迎回来');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            //登录失败
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
        return;
    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功推出');
        return redirect('login');
    }
}
