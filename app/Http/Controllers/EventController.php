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
        $event_list = Event::where('category', $category)->get();
        return view('event/list')->with(['event_list' => $event_list, 'category' => $category]);
    }
    public function detail($event_id){
        // イベント詳細
        $event = Event::find($event_id);
        $attends = Attend::getAttendUsers($event_id);
        return view('event/detail')
        ->with(['event' => $event, 'attends' => $attends]);
    }

}
