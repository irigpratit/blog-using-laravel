<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class PostsController extends Controller
{
//only allow to view the blog content to the guest users
//requires authentication to write blog posts
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function getPostList(){
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Post::all();

        //using the SQL Querry

        // $posts=DB::select('SELECT*FROM posts');
        
        $posts=Post::orderBy('created_at','desc')->get();
        return view('posts.index')->with('posts',$posts);

        // //$data = array();
        // $data = [];

        // $data['posts'] = Post::select('title','body')
        //                     ->orderBy('created_at','desc')->get();       
        // return view('posts.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:2048'
        ]);

        //handle uploaded file
        if($request->hasFile('cover_image')){
            //get filename with extension
            $filenameWithExt=$request->file('cover_image')->getClientOriginalName();
            //Just store fileneme
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //Just get extension
            $extension =$request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }else{
            $fileNameToStore='noimage.jpg';
        }

        //Create post
        $post=new Post;
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        $post->user_id= auth()->user()->id;
        $post->cover_image=$fileNameToStore;
        $post->save();
        // $user->post->save(); 

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::find($id);

        // Check for user to edit post

        if (auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error','Not Authorised');

        }

        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        //Create post
        $post=Post::find($id);
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find($id);

// Check for user to edit post

if (auth()->user()->id !==$post->user_id){
    return redirect('/posts')->with('error','Not Authorised');

}

        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');

    }
}
