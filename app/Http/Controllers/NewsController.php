<?php

namespace App\Http\Controllers;


use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewsFormRequest;
class NewsController extends Controller
{
    public function News(){
        $newsd=News::all();
        return view('admin.news',compact('newsd'));
    }
    public function Create(){
        return view('admin.createnews');
    }
    public function Store(NewsFormRequest $request){
        $data = $request -> validated();
         $news = new News;
         $news->name = $data['name'];
         $news->description = $data['description'];
         if($request->hasfile('image')){
            $file = $request->file('image');
            $filename = time(). "." .$file->getClientOriginalExtension();
            $file->move('uploads/newsd', $filename);
            $news->image = 'uploads/newsd/'.$filename;
        }


         $news->save();

         return redirect()->route('admin.news')->with('message', 'Post added successfully');
     }
     public function Edit($news_id){
        $newsd=News::find($news_id);
        return view('Admin.editnews',compact('newsd'));
    }
    public function Update(NewsFormRequest $request, $news_id){
        $data = $request -> validated();

    $news = News::find($news_id);
    $news->name = $data['name'];

    $news->description = $data['description'];
    if($request->hasfile('image')){
       $file = $request->file('image');
       $filename = time(). "." .$file->getClientOriginalExtension();

       $file->move('uploads/newsd', $filename);
       $news->image = 'uploads/newsd/'.$filename;
   }


    $news->update();

    return redirect()->route('admin.news')->with('message', 'News updated successfully');
    }
    public function Destroy($news_id){
        $newsd=News::find($news_id);
        $newsd->delete();
        return redirect()->route('admin.news')->with('message', 'Post Deleted successfully');
    }
}
