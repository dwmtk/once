<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attend;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailSendController;
use Mail;
use App\Mail\SendAttendMail;
use App\Mail\SendQuitMail;

class AttendController extends Controller
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

    public function attend(Request $request){
        $event = Event::find($request->event_id);
        // 参加済みかの確認　※欠席を含む
        $attend = Attend::getAttendAll(Auth::id(), $event->id);
        if(!empty($attend)){
            if($attend->quit_flg == 0){
                // 参加履歴あり
                return redirect()->back()->with(['error' => 'すでに参加済みのイベントです。',]);
            } elseif($attend->quit_flg == 1) {
                // 欠席履歴あり
                return redirect()->back()->with(['error' => '一度欠席したため参加できません。再参加したい場合はお問い合わせフォームからお願いします。',]);
            }
        }
        if($event->capacity > $event->number){
            $attend = new Attend;
            $attend->event_id = $event->id;
            $attend->user_id = Auth::id();
            $attend->save();
            $event->number = $event->number + 1;
            $event->save();
            
            // 参加完了メール送信
            $to = [['email' => Auth::user()->email, 'name' => Auth::user()->nickname.'様']];
            Mail::to($to)->send(new SendAttendMail(Auth::user(), $event));

            return redirect()->back()->with(['success' => '参加完了しました。参加済みのイベントはマイページから閲覧できます。',]);
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

            // 欠席完了メール送信
            $to = [['email' => Auth::user()->email, 'name' => Auth::user()->nickname.'様']];
            Mail::to($to)->send(new SendQuitMail(Auth::user(), $event));

            return redirect('home')->with(['success' => 'イベントの欠席が完了しました。']);
        }
        return redirect('home');
    }
}
