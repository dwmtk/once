<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    //
    public static function getAttendEvents($user_id){
        // 特定のユーザが参加しているイベント一覧を取得　※辞退を含まない
        return \DB::select('select * from events inner join attends on events.id = attends.event_id where attends.quit_flg = 0 attends.user_id = ? order by attends.id desc', [$user_id]);
    }
    public static function getAttendEventsAll($user_id){
        // 特定のユーザが参加しているイベント一覧を取得　※辞退済みも含む
        return \DB::select('select * from events inner join attends on events.id = attends.event_id where attends.user_id = ? order by attends.id desc', [$user_id]);
    }
    public static function getAttendUsers($event_id){
        // 特定のイベントに参加しているユーザ一覧を取得　※辞退を含まない
        return \DB::select('select * from users inner join attends on users.id = attends.user_id where attends.quit_flg = 0 and attends.event_id = ?',[$event_id]);
    }
    public static function getAttendUsersAll($event_id){
        // 特定のイベントに参加しているユーザ一覧を取得　※辞退済みも含む
        return \DB::select('select * from users inner join attends on users.id = attends.user_id where attends.event_id = ?',[$event_id]);
    }
    public static function getAttendUsersDetailAll($event_id){
        // 特定のイベントに参加しているユーザ一覧を取得　※辞退済みも含む
        return \DB::select('select * from users inner join attends on users.id = attends.user_id where attends.event_id = ?',[$event_id]);
    }
    public static function getAttend($user_id, $event_id){
        // ユーザがイベントに参加しているかを確認　※辞退済みも含まない
        return Attend::where('user_id', $user_id)->where('event_id', $event_id)->where('quit_flg', 0)->first();
    }
    public static function getAttendAll($user_id, $event_id){
        // ユーザがイベントに参加しているかを確認　※辞退済みも含む
        return Attend::where('user_id', $user_id)->where('event_id', $event_id)->first();
    }
}
