<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventUser;

class EventUserController extends Controller
{
    public function index($user_id,$event_id){
        $event_user = EventUser::where([['user_id','=',$user_id],['event_id','=',$event_id]])->get();
        return response()->json($event_user);
    }

    public function event(Request $request){
        EventUser::create([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil JOIN EVENT'
        ]);
    }
}
