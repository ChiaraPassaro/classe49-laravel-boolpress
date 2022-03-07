<?php

namespace App\Http\Controllers\Admin;

use App\Model\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prophecy\Call\Call;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->roles()->get()->contains('1')) {
            // order posts and paginate
            $posts = Post::orderBy('created_at', 'desc')->paginate(20);
        } else {
            $posts = Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(20);
        }

        //we can create a new carbon object and pass to view
        //or use directly in blade Carbon\Carbon::
        $carbon = new Carbon();

        return view('admin.posts.index', ['posts' => $posts, 'carbon' => $carbon]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        // anly posts user
        $posts = Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //categories and tags for select and checkboxes
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', ['categories' => $categories, 'tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        //validate also category and tags
        $postValidate = $request->validate(
            [
                'title' => 'required|max:240',
                'content' => 'required',
                'category_id' => 'exists:App\Model\Category,id',
                'tags.*' => 'nullable|exists:App\Model\Tag,id',
                'image' => 'nullable|image'
            ]
        );

        //check photo and store
        if (!empty($data['image'])) {
            $img_path = Storage::put('uploads', $data['image']);
            $data['image'] = $img_path;
        }

        $post = new Post();
        $post->fill($data);
        $post->slug = $post->createSlug($data['title']);
        $post->save();

        //create a record in pivot table
        if (!empty($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }



        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // ddd($post->created_at);
        // $now = new Carbon();
        // // dd($now);
        // $postDate = new Carbon($post->created_at);
        // // // dd($postDate);
        // dd($now->isSameDay($postDate));
        return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //if is not admin and not author of this post 
        if (Auth::user()->id != $post->user_id && !Auth::user()->roles()->get()->contains(1)) {
            abort('403');
        }

        //categories and tags for select and checkboxes
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();

        //if is not admin and not author of this post 
        if (Auth::user()->id != $post->user_id && !Auth::user()->roles()->get()->contains(1)) {
            abort('403');
        }

        //validate
        $postValidate = $request->validate(
            [
                'title' => 'required|max:240',
                'content' => 'required',
                'category_id' => 'exists:App\Model\Category,id',
                'tags.*' => 'nullable|exists:App\Model\Tag,id',
                'image' => 'nullable|image'
            ]
        );


        //check photo and store
        if (!empty($data['image'])) {
            Storage::delete($post->image);

            $img_path = Storage::put('uploads', $data['image']);
            $post->image = $img_path;
        }

        //check if data changed
        if ($data['title'] != $post->title) {
            $post->title = $data['title'];
            $post->slug = $post->createSlug($data['title']);
        }
        if ($data['content'] != $post->content) {
            $post->content = $data['content'];
        }
        if ($data['category_id'] != $post->category_id) {
            $post->category_id = $data['category_id'];
        }

        //update save on DB
        $post->update();


        if (!empty($data['tags'])) {
            //sync tags delete old tags and add new tags in pivot table
            $post->tags()->sync($data['tags']);
        } else {
            //if we don't have tags we detach all
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // dd(Auth::user()->id != $post->user_id);
        // dd(!Auth::user()->roles()->get()->contains(1));

        if (Auth::user()->id != $post->user_id && !Auth::user()->roles()->get()->contains(1)) {
            abort('403');
        }

        //delete records in pivot table otherwise we'll have a constrain error
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', "Post id $post->id deleted");
    }
}
