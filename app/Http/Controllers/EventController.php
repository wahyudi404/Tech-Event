<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(){
        $event = Event::orderBy('created_at', 'DESC')->get();

        return response()->json($event);
    }

    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'name_event' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'date' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 403);
        }

        $event = Event::create([
            'name_event' => $request->name_event,
            'address' => $request->address,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event berhasil dibuat!',
            'data' => $event,
        ]);
    }

    public function destroy($id){
        $event = Event::find($id);

        if(!empty($event->image_url) && file_exists(public_path('images') . '/' . $event->image_url)){
            unlink(public_path('images') . '/' . $event->image_url);
        }

        $event->delete();

        return response()->json([
            'message'=> 'Event berhasil dihapus'
        ]);
    }

    public function edit($id){
        $event = Event::find($id);
        return response()->json($event);
    }

    public function update(Request $request, $id){
        $validation = Validator::make($request->all(), [
            'name_event' => 'required|string',
            'address' => 'required|string',
            'description' => 'required|string',
            'date' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 403);
        }

        $event  = Event::find($id);
        $event->update([
            'name_event' => $request->name_event,
            'address' => $request->address,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event berhasil diubah!'
        ]);
    }

    public function upload(Request $request, $id){
        $event = Event::find($id);
        $nameImg = time() . '.' . $request->photo->extension();
        $path = public_path('images');

        if(!empty($event->image_url) && file_exists($path . '/' . $event->image_url)){
            unlink($path . '/' . $event->image_url);
        }

        $event->image_url = $nameImg;
        $event->save();

        $request->photo->move($path, $nameImg);
        return response()->json(true);
    }
}
