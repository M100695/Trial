<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use DB;

class PostsController extends Controller
{
    // functions na kelangan: ->index, create, store, edit, update, show, destroy<--

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //auth para No account = no create or edit or delete posts. Note:need exemption para makita yung view
    public function __construct()
    {
        $this->middleware('auth',['except'=> ['index', 'show']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        //to show the post by newest added
        //$posts = Post::orderBy('title', 'desc')->get();

        //to show the data using SQL syntax in Database -->Note need to have "use DB;"
        //$posts = DB::select('SELECT * FROM posts');

        return view('posts.index')->with('posts', $posts);
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
        //need to validate if the form is filled up or not. 
        $this->validate($request,
        [
            'title' => 'required',
            'body' => 'required',
            'cover_image'=>'image|nullable|max:1999' //2mb only and required image to upload
            //para maset yung hindi required na image dagdagan lang ng |nullable
        ]);

        //handle the file upload
        if($request->hasFile('cover_image'))
        {   
            //get file name extensions
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get filename only
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           

            //getextension
            $extension =$request->file('cover_image')->getClientOriginalExtension();
            //filename to store to Database
            $fileNameToStore = $filename . '_'. time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cove_images', $fileNameToStore);
        }
            else
            {
                $fileNameToStore = 'noimage.jpg';
            }
            
        

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        //this is for Not login acc just want to edit the post
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorized Page.');
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
       //need to validate if the form is filled up or not. 
       $this->validate($request,
       [
           'title' => 'required',
           'body' => 'required',
           'cover_image'=>'image|nullable|max:1999' //2mb only and required image to upload
           //para maset yung hindi required na image dagdagan lang ng |nullable
       ]);

       //handle the file upload
       if($request->hasFile('cover_image'))
       {   
           //get file name extensions
           $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
           //get filename only
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          

           //getextension
           $extension =$request->file('cover_image')->getClientOriginalExtension();
           //filename to store to Database
           $fileNameToStore = $filename . '_'. time().'.'.$extension;
           //upload image
           $path = $request->file('cover_image')->storeAs('public/cove_images', $fileNameToStore);
       }        

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image'))
        {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
       

        return redirect('/posts')->with('success', 'Post Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //this is for Not login acc just want to delete the post
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error', 'Unauthorized Page.');
        }

        //this is for storage of image that needs to delete also
        if($post->cover_image != 'noimage.jpg')
        {
            Storage::delete('public/cove_images/' . $post->cover_image);
        }

        $post = POST::find($id);
        $post->delete();
        return redirect('/posts')->with('success');
    }
}
