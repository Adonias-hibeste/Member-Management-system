<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostFormRequest;


class PostController extends Controller
{
public function Post(){
    $posts=Post::all();
    return view('admin.post',compact('posts'));
}
public function Create(){
    return view('admin.createpost');
}
public function Store(PostFormRequest $request){
   $data = $request -> validated();

    $post = new Post;
    $post->name = $data['name'];

    $post->description = $data['description'];
    if($request->hasfile('image')){
        $file = $request->file('image');
        $filename = time(). "." .$file->getClientOriginalExtension();

        $file->move('uploads/posts', $filename);
        $post->image = 'uploads/posts/'.$filename;
    }


    $post->save();

    return redirect()->route('admin.post')->with('message', 'Post added successfully');
}
    public function Edit($post_id){
        $posts=Post::find($post_id);
        return view('Admin.edit',compact('posts'));
    }

    public function Update(PostFormRequest $request, $post_id){
        $data = $request -> validated();

    $post = Post::find($post_id);
    $post->name = $data['name'];

    $post->description = $data['description'];
    if($request->hasfile('image')){
        $file = $request->file('image');
        $filename = time(). "." .$file->getClientOriginalExtension();

        $file->move('uploads/posts', $filename);
        $post->image = 'uploads/posts/'.$filename;
    }


    $post->update();

    return redirect()->route('admin.post')->with('message', 'Post updated successfully');
    }
    public function Destroy($post_id){
        $posts=Post::find($post_id);
        $posts->delete();
        return redirect()->route('admin.post')->with('message', 'Post Deleted successfully');
    }

}
