<?php

namespace App\Http\Controllers;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Post;
use Illuminate\Http\Request;
class PostsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index()
    {

        return view('blog.index')->with('posts',Post::orderBy('updated_at','DESC')->get());
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
      $request->validate([
          'title'=>'required',
          'description'=>'required',
          'image'=>'required|mimes:jpg,png,jpeg|max:5048'
      ]);
      $newimagename=uniqid()."-".$request->title .".".$request->image->extension();
     $request->image->move(public_path('images'),$newimagename);
     $slug=SlugService::createSlug(Post::class,'slug',$request->title);

     Post::create([
         'title' => $request->input('title'),
         'description' => $request->input('description'),
         'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
         'image_path' => $newimagename,
         'user_id' => auth()->user()->id
     ]);
     return redirect('/blog')->with('message','Post Successfuly Created');
    }


    public function show($slug)
    {

        return view('blog.show')->with('post',Post::where('slug',$slug)->first());

    }

    public function edit($slug)
    {
        return view('blog.edit')->with('post',Post::where('slug',$slug)->first());
    }

    public function update(Request $request, $slug)
    {
        Post::where('slug',$slug)
            ->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'slug' => SlugService::createSlug(Post::class, 'slug', $request->title),
                'user_id' => auth()->user()->id
            ]);
        return redirect('/blog')->with('message','Post Successfuly Updated');
    }


    public function destroy($slug)
    {
        $post=Post::where('slug',$slug);
        $post->delete();
        return redirect('/blog')->with('message','Post Successfuly Deleted');
    }
}


