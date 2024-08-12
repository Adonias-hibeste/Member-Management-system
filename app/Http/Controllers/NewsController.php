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
         $news->slug = $data['slug'];
         $news->description = $data['description'];
         $news->yt_iframe = $data['yt_iframe'] ?? '';
         $news->meta_title = $data['meta_title'];
         $news->meta_description = $data['meta_description'];
         $news->meta_keyword = $data['meta_keyword'];
         $news->status = $request->status==true? '1':'0';
        
         
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
    $news->slug = $data['slug'];
    $news->description = $data['description'];
    $news->yt_iframe = $data['yt_iframe'] ?? '';
    $news->meta_title = $data['meta_title'];
    $news->meta_description = $data['meta_description'];
    $news->meta_keyword = $data['meta_keyword'];
    $news->status = $request->status==true? '1':'0';

    
    $news->update();

    return redirect()->route('admin.news')->with('message', 'Post updated successfully');
    }
    public function Destroy($news_id){
        $newsd=News::find($news_id);
        $newsd->delete();
        return redirect()->route('admin.news')->with('message', 'Post Deleted successfully');
    }
}
