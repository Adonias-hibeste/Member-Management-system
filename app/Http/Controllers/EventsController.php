<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventsFormRequest;
use App\Rules\TimeValidation;

class EventsController extends Controller
{
    public function Events(){
        $eventsd=Events::all();
        return view('admin.events',compact('eventsd'));
    }
    public function Create(){
        return view('admin.createevents');
    }
    public function Store(EventsFormRequest $request){
        $data = $request -> validated();
         $events = new Events;
         $events->name = $data['name'];

         $events->description = $data['description'];
         if($request->hasfile('image')){
            $file = $request->file('image');
            $filename = time(). "." .$file->getClientOriginalExtension();

            $file->move('uploads/eventsd', $filename);
            $events->image = 'uploads/eventsd/'.$filename;
        }

         $events->save();

         return redirect()->route('admin.events')->with('message', 'Post added successfully');
     }
     public function Edit($events_id){
        $eventsd=Events::find($events_id);
        return view('Admin.editevents',compact('eventsd'));
    }
    public function Update(EventsFormRequest $request, $events_id){
        $data = $request -> validated();
    $events = Events::find($events_id);
    $events->name = $data['name'];

    $events->description = $data['description'];
    if($request->hasfile('image')){
       $file = $request->file('image');
       $filename = time(). "." .$file->getClientOriginalExtension();

       $file->move('uploads/eventsd', $filename);
       $events->image = 'uploads/eventsd/'.$filename;
   }

    $events->update();

    return redirect()->route('admin.events')->with('message', 'Event updated successfully');
    }
    public function Destroy($events_id){
        $eventsd=Events::find($events_id);
        $eventsd->delete();
        return redirect()->route('admin.events')->with('message', 'Post Deleted successfully');
    }
    public function getEvents()
    {
        $events = Events::select('id', 'name')->get();
        return response()->json($events);
    }

}
