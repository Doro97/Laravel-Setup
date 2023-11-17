<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function deletePost(Post $post){
        if (auth()->user()->id === $post['user_id']){

            $post->delete();
        }
        return redirect('/');

   }
   
    public function actuallyUpdatePost(Post $post, Request $request){
        if (auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }

        $incomingfields = $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $incomingfields['title'] = strip_tags($incomingfields['title']);
        $incomingfields['body'] = strip_tags($incomingfields['body']);

        $post->update($incomingfields);
        return redirect('/');
   }
   
   
    public function showEditScreen(Post $post){
        if (auth()->user()->id !== $post['user_id']){
            return redirect('/');
        }
        
        return view('edit-post',['post'=> $post]);
   }
   
   
    public function createPost(Request $request) {
        $incomingfields = $request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $incomingfields['title'] = strip_tags($incomingfields['title']);
        $incomingfields['body'] = strip_tags($incomingfields['body']);
        $incomingfields['user_id'] = auth()->id();

        Post::create($incomingfields);
        return redirect('/');
    }
}
