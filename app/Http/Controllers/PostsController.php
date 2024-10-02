<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    // creating a new controller instance
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts= Post::all(); //this returns all items from db
        // $posts = Post::orderBy('title', 'desc')->get(); //this returns items by the title in descending order meaning the most recent post comes first
        // return Post::where('title', 'Second post')->get(); //returns only the specific post mentioned

        // $posts= DB::select('SELECT * FROM posts'); //this can be used when u want to use raw sql instead of the ELoquent ORM

        // $posts = Post::orderBy('title', 'desc')->take(1)->get(); //this returns only 1 item
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10); //this handles pagination
        $users = User::all();
        return view('posts.index', compact('posts', 'users'));
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
        $this->validate($request, [
            'title'=>'required',
            'body'=> 'required',
            'cover_img'=>'image|nullable|max:1999' //this validation means it has to be an image wether jpg, png etc and it shud be maximum 2mb so that apache doesnt throw an error, and the nullable is to meaning uploading is optional
        ]);

        //handle file upload
        if($request->hasFile('cover_img')){
            //get file name with the extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            //get just filename
            $filename=pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            //file to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);

        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //create a post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_img = $fileNameToStore;
        $post->save();

        return redirect('posts')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //to view only one blog post
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorised page please log in to urs');
        }

        return view('posts.edit')->with('post', $post);
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
        echo "5";
        $this->validate($request, [
            'title'=>'required',
            'body'=> 'required'
        ]);

        //handle file upload
        if($request->hasFile('cover_img')){
            //get file name with the extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            //get just filename
            $filename=pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just extension
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            //file to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_img')->storeAs('public/cover_images', $fileNameToStore);

        }

        //create a post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_img')){
            $post->cover_img = $fileNameToStore;
        }
        $post->save();

        return redirect('posts')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('posts')->with('error', 'Unauthorised page');
        }

        if($post->cover_img != 'noimage.jpg'){
            //delete image
            Storage::delete('public/cover_images/'.$post->cover_img);
        }
        $post->delete();
        return redirect('posts')->with('success', 'Post deleted');

    }
}
