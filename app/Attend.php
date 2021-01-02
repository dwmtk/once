<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    //
    public static function getAttendThisUserEvents($user_id){
        // 特定のユーザが参加しているイベント一覧を取得　※辞退を含まない
        return \DB::select('select * from events inner join attends on events.id = attends.event_id where attends.quit_flg = 0 attends.user_id = ? order by attends.id desc', [$user_id]);
    }
    public static function getAttendThisUserEvents_pulsQuit($user_id){
        // 特定のユーザが参加しているイベント一覧を取得　※辞退済みも含む
        return \DB::select('select * from events inner join attends on events.id = attends.event_id where attends.user_id = ? order by attends.id desc', [$user_id]);
    }
    public static function getAttendEventUsers($event_id){
        // 特定のイベントに参加しているユーザ一覧を取得　※辞退を含まない
        return \DB::select('select * from users inner join attends on users.id = attends.user_id where attends.quit_flg = 0 and attends.event_id = ?',[$event_id]);
    }
    public static function getAttendEventUsers_plusQuit($event_id){
        // 特定のイベントに参加しているユーザ一覧を取得　※辞退済みも含む
        return \DB::select('select * from users inner join attends on users.id = attends.user_id where attends.event_id = ?',[$event_id]);
    }
    // public static function getAttendUsersDetailAll($event_id){
    //     // 特定のイベントに参加しているユーザ一覧を取得　※辞退済みも含む
    //     return \DB::select('select * from users inner join attends on users.id = attends.user_id where attends.event_id = ?',[$event_id]);
    // }
    public static function getAttendThisUser($user_id, $event_id){
        // ユーザの参加しているイベントを確認
        return Attend::where('user_id', $user_id)->where('event_id', $event_id)->first();
    }
}
