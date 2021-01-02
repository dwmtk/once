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
        // イベント参加

        $event = Event::find($request->event_id);
        if($event->stop_flg == 1){
            //打ち切りの場合
            return redirect()->back()->with(['error' => 'イベントが打ち切られているため参加できません。',]);
        }
        if($event->capacity > $event->number){
            // 定員に空きがある場合
            // 参加履歴を取得
            $attend = Attend::getAttendThisUser(Auth::id(), $event->id);
            if(!empty($attend)){
                // 参加履歴がある場合
                if($attend->quit_flg == 1){
                    // 欠席している場合
                    // 参加に更新
                    $attend->quit_flg = 0;
                    $attend->save();
                } else {
                    // 参加済みの場合
                    return redirect()->back()->with(['error' => 'すでに参加済みのイベントです。',]);
                }
            }else{
                // 参加履歴がない場合
                // 参加
                $attend_new = new Attend;
                $attend_new->event_id = $event->id;
                $attend_new->user_id = Auth::id();
                $attend_new->save();
            }
            // イベントの参加人数を＋１
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
        
        // 参加履歴を確認
        $attend = Attend::getAttendThisUser($request->user_id, $request->event_id);
        if(empty($attend)){
            // 参加履歴が無い場合エラー
            return view('error')->with('message', '参加していないイベントのため欠席できません。');
        }
        if($attend->quit_flg == 1){
            // 欠席済の場合エラー
            return view('error')->with('message', 'すでに欠席済みのイベントです。');
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
}
