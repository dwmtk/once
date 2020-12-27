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
                // 管理者ユーザ以外の場合はホーム画面にリダイレクト
                return redirect('home');
            }
            return $next($request);
        });
    }
    public function index(){
        $events = Event::orderBy('id', 'desc')->get();
        return view('manage/index')->with(['events' => $events]);
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
            'fee' => ['required', 'integer'],
            'place' => ['required', 'string', 'max:255'],
            'start_y' => ['required','string', 'min:4', 'max:4'],
            'start_m' => ['required','string', 'min:2', 'max:2'],
            'start_d' => ['required','string', 'min:2', 'max:2'],
            'start_hour' => ['required','string', 'min:2', 'max:2'],
            'start_min' => ['required','string', 'min:2', 'max:2'],
            'end_y' => ['required','string', 'min:4', 'max:4'],
            'end_m' => ['required','string', 'min:2', 'max:2'],
            'end_d' => ['required','string', 'min:2', 'max:2'],
            'end_hour' => ['required','string', 'min:2', 'max:2'],
            'end_min' => ['required','string', 'min:2', 'max:2'],
        ]);
        //日付を成型
        $start = $request->start_y.$request->start_m.$request->start_d.$request->start_hour.$request->start_min;
        $end = $request->end_y.$request->end_m.$request->end_d.$request->end_hour.$request->end_min;
        //イベントを保存
        $event = new Event;
        $event->name = $request->name;
        $event->category = $request->category;
        $event->content = $request->content;
        $event->capacity = $request->capacity;
        $event->fee = $request->fee;
        $event->place = $request->place;
        $event->start = $start;
        $event->end = $end;
        $event->save();

        if($request->image1){
            // 画像を保存
            $file_name = $request->file('image1')->getClientOriginalName();
            $file_pass = 'public/event/'.$event->id;
            $request->file('image1')->storeAs($file_pass, $file_name);
            $event->image = $file_name;
            $event->save();
        }
        return redirect('manage/index')->with(['success' => 'イベントの新規作成を行いました。']);
    }
    public function update_get($event_id){
        $event = Event::find($event_id);
        $attends = Attend::getAttendUsersAll($event->id);
        return view('manage/update')->with(['event' => $event, 'attends' => $attends]);
    }
    public function update_post(Request $request){
        // 入力チェック
        $this -> Validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'min:2'],
            'content' => ['required', 'string'],
            'capacity' => ['required', 'integer', 'max:9999'],
            'fee' => ['required', 'integer'],
            'place' => ['required', 'string', 'max:255'],
            'start_y' => ['required','string', 'min:4', 'max:4'],
            'start_m' => ['required','string', 'min:2', 'max:2'],
            'start_d' => ['required','string', 'min:2', 'max:2'],
            'start_hour' => ['required','string', 'min:2', 'max:2'],
            'start_min' => ['required','string', 'min:2', 'max:2'],
            'end_y' => ['required','string', 'min:4', 'max:4'],
            'end_m' => ['required','string', 'min:2', 'max:2'],
            'end_d' => ['required','string', 'min:2', 'max:2'],
            'end_hour' => ['required','string', 'min:2', 'max:2'],
            'end_min' => ['required','string', 'min:2', 'max:2'],
        ]);
        //日付を保存
        $start = $request->start_y.$request->start_m.$request->start_d.$request->start_hour.$request->start_min;
        $end = $request->end_y.$request->end_m.$request->end_d.$request->end_hour.$request->end_min;
        //イベントを保存
        $event = Event::find($request->event_id);
        $event->name = $request->name;
        $event->category = $request->category;
        $event->content = $request->content;
        $event->capacity = $request->capacity;
        $event->fee = $request->fee;
        $event->place = $request->place;
        $event->start = $start;
        $event->end = $end;
        if($request->image1){
            // 画像を保存
            $file_name = $request->file('image1')->getClientOriginalName();
            $file_pass = 'public/event/'.$event->id;
            $request->file('image1')->storeAs($file_pass, $file_name);
            $event->image = $file_name;
        }
        $event->save();
        return redirect()->back()->with(['success' => 'イベントの編集が完了しました。']);
    }
    public function stop($event_id){
        //イベント打ち切り
        $event = Event::find($event_id);
        $event->stop_flg = '1';
        $event->save();
        return redirect()->back()->with(['warning' => 'イベントを打ち切りました。']);
    }
    public function member_list(){
        $users = \DB::select('select * from users order by id desc');
        return view('manage/member_list')->with(['users' => $users]);
    }
    public function howto(){
        return view('manage/howto');
    }
}
