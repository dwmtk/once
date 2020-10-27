<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MailSendController;
use Mail;

class UserController extends Controller
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
    public function edit_get(){
        // プロフィール編集ページを開く
        return view('home/edit');
    }
    public function edit_post(Request $request){
        // プロフィール編集処理

        // 入力チェック
        $this -> Validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:50'],
            'work' => ['required', 'string', 'max:255'],
            'prefecture' => ['required', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:50'],
        ]);
        if(Auth::user()->email != $request->email){
            $this -> Validate($request, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
            Auth::user()->email = $request->email;
        }
        Auth::user()->nickname = $request->nickname;
        Auth::user()->name = $request->name;
        Auth::user()->work = $request->work;
        Auth::user()->prefecture = $request->prefecture;
        Auth::user()->city = $request->city;
        Auth::user()->save();
        return redirect('home/edit')->with(['success' => '個人情報の変更が完了しました。']);
    }
    public function edit_password_get(){
        // パスワード変更ページを開く
        return view('home/edit_password');
    }
    public function edit_password_post(Request $request){
        // パスワード変更処理
        
        // 入力チェック
        $this -> Validate($request, [
            'password_old' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        //現在のパスワードが正しいかを調べる
        if(!(Hash::check($request->password_old, Auth::user()->password))) {
            return redirect()->back()->with(['error' => '現在のパスワードが間違っています。']);
        }
        //現在のパスワードと新しいパスワードが違っているかを調べる
        if(strcmp($request->password_old, $request->password) == 0) {
            return redirect()->back()->with(['error' => '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。']);
        }
        //パスワードを変更
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('home')->with(['success' => 'パスワードの変更が完了しました。']);
    }
}
