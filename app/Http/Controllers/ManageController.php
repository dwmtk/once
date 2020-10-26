<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attend;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {

            if(Auth::user()->user_type != 2){
                // 管理者ユーザ以外の場合
                return redirect('home');
            }

            return $next($request);
        });
    }
    public function index(){
        $events = Event::orderBy('id', 'desc')->get();
        return view('manage/index')
        ->with([
            'events' => $events
        ]);
    }
    public function insert_get(){
        return view('manage/insert');
    }
    public function insert_post(Request $request){
        // 入力チェック
        $this -> Validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'min:2'],
            'content' => ['required', 'string'],
            'capacity' => ['required', 'integer', 'max:9999'],
            'start' => ['required','string', 'min:12', 'max:12'],
            'end' => ['required','string', 'min:12', 'max:12'],
        ]);
        $event = new Event;
        $event->name = $request->name;
        $event->category = $request->category;
        $event->content = $request->content;
        $event->capacity = $request->capacity;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();
        return redirect('manage/index')
        ->with([
            'success_insert', 'イベントの新規作成を行いました。'
        ]);
    }
    public function update_get($event_id){
        $event = Event::find($event_id);
        $attends = Attend::getAttendUsersAll($event->id);
        return view('manage/update')
        ->with([
            'event' => $event,
            'attends' => $attends
        ]);
    }
    public function update_post(Request $request){
        // 入力チェック
        $this -> Validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'min:2'],
            'content' => ['required', 'string'],
            'capacity' => ['required', 'integer', 'max:9999'],
            'start' => ['required','string', 'min:12', 'max:12'],
            'end' => ['required','string', 'min:12', 'max:12'],
        ]);
        $event = Event::find($request->event_id);
        $event->name = $request->name;
        $event->category = $request->category;
        $event->content = htmlspecialchars($request->content);
        $event->capacity = $request->capacity;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->save();
        return redirect('manage/index')
        ->with([
            'success_insert', 'イベントの編集が完了しました。'
        ]);
    }
    public function stop($event_id){
        $event = Event::find($event_id);
        $event->stop_flg = '1';
        $event->save();
        dd($event);
        return view('manage/index');
    }
    public function member_list(){
        $users = \DB::select('select * from users order by id desc');
        return view('manage/member_list')
        ->with([
            'users' => $users
        ]);
    }
}
