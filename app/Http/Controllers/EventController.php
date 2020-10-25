<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Attend;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //
    public function list($category){
        $event_list = Event::where('category', $category)->get();
        return view('event/list')
        ->with([
            'event_list' => $event_list
            ]);
    }
    public function detail($event_id){
        $event = Event::where('id', $event_id)->first();
        $attends = Attend::getAttendUsers($event_id);
        return view('event/detail')
        ->with([
            'event' => $event,
            'attends' => $attends
        ]);
    }

}
