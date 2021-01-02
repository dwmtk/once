<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attend;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
    }
    public function top(){
        $events = Event::all();
        return view('welcome')->with(['events' => $events]);
    }
    public function list($category){
        // イベント一覧
        $event_list = Event::where('category', $category)->orderBy('start','desc')->get();
        return view('event/list')->with(['event_list' => $event_list, 'category' => $category]);
    }
    public function detail($event_id){
        // イベント詳細
        $event = Event::find($event_id);
        
        // 参加者一覧
        $attends = Attend::getAttendEventUsers($event_id);

        // 参加・欠席ボタンの制御（初期状態：参加ボタン押下不可・欠席ボタン非表示）
        $attend_btn = 'disabled';
        $quit_btn = 'none';
        $attend_log = -1;   // -1:参加履歴なし／0:参加／1:欠席
        if($this->middleware('Auth') && (strtotime($event->start) > strtotime("now"))){

            // 参加履歴取得
            $attend_this_user = Attend::getAttendThisUser(Auth::id(), $event_id);
            if(empty($attend_this_user)){
                $attend_log = -1;
            }else{
                $attend_log = $attend_this_user->quit_flg;
            }

            if($attend_log == -1 || $attend_log == 1){
                // 参加していない（欠席している場合も含む）
                if(($event->stop_flg == 0) && ($event->capacity > $event->number)){
                    // 参加ボタン押下可能・欠席ボタン非表示
                    $attend_btn = '';
                    $quit_btn = 'none';
                }
            }elseif($attend_log == 0){
                // 参加している
                // 参加ボタン押下不可・欠席ボタン表示
                $attend_btn = 'disabled';
                $quit_btn = '';
            }
        }
        return view('event/detail', compact('event', 'attends', 'attend_log', 'attend_btn', 'quit_btn'));
    }
}
