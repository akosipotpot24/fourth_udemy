<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Events\PostEvent;
use Illuminate\Http\Request;
use App\Events\OurExampleEvent;

class PostController extends Controller
{
    //
    public function search($term){
        $post = Post::search($term)->get();
        $post->load('user:id,username,avatar');
        return $post;
    }

    public function actuallyUpdate(Post $post,Request $request){
        $incomingFields = $request->validate([
            'title' =>'required',
            'body' => 'required'
        ]);
        $incomingFields['title']  = strip_tags($incomingFields['title']);
        $incomingFields['body']  = strip_tags($incomingFields['body']);
        $post->update($incomingFields);
        return back()->with('success','Post successfully updated');
    }

    public function showEditForm(Post $post){
        return view('edit-post',['post'=>$post]);
    }

    public function delete(Post $post){
        $post->delete();
        return redirect('/profile/'.auth()->user()->username)->with('success','Post successfully deleted');
    }
    public function viewSinglePost(Post $post){
        
        return view('single-post',['post'=>$post]);
    }
    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title' =>'required',
            'body' => 'required'
        ]);
        $incomingFields['title']  = strip_tags($incomingFields['title']);
        $incomingFields['body']  = strip_tags($incomingFields['body']);
        $incomingFields['user_id']  = auth()->id();
        $newPost = Post::create($incomingFields);
        event(new PostEvent(['username'=> auth()->user()->username, 'title'=>  $incomingFields['title'] ] ));
        return redirect("/post/{$newPost->id}")->with('success','New post successfully created');
    }
    public function showCreateForm(){
        return view('create-post');
    }

}
