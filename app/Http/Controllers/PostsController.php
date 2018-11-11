<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Brought in to be able to delete the image in storage
use Illuminate\Support\Facades\Storage;
use App\Post;   // Bring in the Post model to use in the controller

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * Prevents guests from accessing some methods except index ad show
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the posts/resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Orders the posts by created_at(desc) to display 10 at once i.e paginate(the pagination link will be on posts.index to paginate)
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        // Pass all the posts along with the view
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new post/resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Leads to the create view in posts
        return view('posts.create');
    }

    /**
     * Store a newly created post/resource in database/storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validates the sent data/request
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            // cover image props - it has to be an image. it is optional and the size is 1999kb i.e 1.9mb
            'cover_image' => 'image|nullable|max:1999',
        ]);

        // Handles File Upload. Get the filename with extension
        if($request->hasFile('cover_image')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just the filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get the ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload the Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {       // If no image is uploaded, use the default image - noimage.jpg
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post from the sent data from create.blade.php
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // Get the user id of the authenticated user
        $post->user_id = auth()->user()->id;
        // Get the uploaded cover image
        $post->cover_image = $fileNameToStore;
        $post->save();
        // Redirect to the posts or blog page
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified/requested post/resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Finds the post with the id
        $post = Post::find($id);
        // Pass the found post along with the view
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified/requested post/resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Brings in the post to be edited
        $post = Post::find($id);
        // Check for the correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('posts')->with('error', 'Unathourized Page');
        }
        // Pass the post along with the view
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified/requested post/resource in database/storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validates the updated data/request
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        // Handles File Upload. Get the filename with extension but don't replace if they didn't update the cover image
        if($request->hasFile('cover_image')) {
            // Get filename with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just the filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get the ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload the Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        // Finds the post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // Get the file
        if($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        // Redirect to the posts or blog page
        return redirect('/posts')->with('success', 'Post Updated');

    }

    /**
     * Remove the specified/requested post/resource from database/storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Finds the post with the specific id and delete
        $post = Post::find($id);
        // Check for the correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('posts')->with('error', 'Unathourized Page');
        }

        if($post->cover_image != 'noimage.jpg') {
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        // Redirect to the posts or blog page
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
