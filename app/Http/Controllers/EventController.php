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
        // 参加状況（$attend_this_user = null：非会員・非参加、0：参加、1：欠席）
        $attend_this_user = null;
        if($this->middleware('Auth')){
            // ログイン済みのユーザ
            $attend_this_user = Attend::getAttendThisUser(Auth::id(), $event_id);
        }
        return view('event/detail')
        ->with(['event' => $event, 'attends' => $attends, 'attend_this_user' => $attend_this_user]);
    }
}
