<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attend;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ユーザが参加済みの一覧を取得　※欠席も含む
        $my_events = Attend::getAttendEventsAll(Auth::id());
        return view('home')
        ->with([
            'my_events' => $my_events
        ]);
    }
    public function attend(Request $request){
        $event = Event::where('id', $request->event_id)->first();
        // 参加済みかの確認　※欠席を含む
        // $attend = Attend::where('user_id', Auth::id())->where('event_id', $event->id)->first();
        $attend = Attend::getAttendAll(Auth::id(), $event->id);
        if(!empty($attend)){
            if($attend->quit_flg == 0){
                // 参加履歴あり
                return redirect()->back()
                ->with([
                    'error_aleady' => 'すでに参加済みのイベントです。',
                ]);
            } elseif($attend->quit_flg == 1) {
                // 欠席履歴あり
                return redirect()->back()
                ->with([
                    'error_aleady_quit' => '一度欠席したため参加できません。再参加したい場合はお問い合わせフォームからお願いします。',
                ]);
            }
        }
        if($event->capacity > $event->number){
            $attend = new Attend;
            $attend->event_id = $event->id;
            $attend->user_id = Auth::id();
            $attend->save();
            $event->number = $event->number + 1;
            $event->save();
            return redirect()->back()
            ->with([
                'success_attend' => '参加完了しました。参加済みのイベントはマイページから閲覧できます。',
            ]);
        }
        return view('error');
    }
    public function quit(Request $request){
        // イベント欠席
        if($request->execute == 'on'){
            // イベントに参加しているかどうか確認
            $attend = Attend::find($request->id);
            if(empty($attend)){
                // イベントに参加していない場合
                return view('error');
            }
            // ステータスを欠席に変更
            $attend->quit_flg = '1';
            $attend->save();
            
            // イベントの参加人数を1人減らす
            $event = Event::find($attend->event_id);
            $event->number = $event->number - 1;
            $event->save();

            return redirect('home')
            ->with([
                'success_quit' => 'イベントの欠席が完了しました。'
                ]);
        }
        return redirect('home');
    }

    public function edit_get(){
        return view('home/edit');
    }
    public function edit_post(Request $request){
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
        return redirect('home/edit')
        ->with([
            'success_edit' => '個人情報の変更が完了しました。'
        ]);
    }
    public function edit_password_get(){
        return view('home/edit_password');
    }
    public function edit_password_post(Request $request){
        return view('home')
        ->with([
            'success_edit_password' => 'パスワードの変更が完了しました。'
        ]);
    }
}
