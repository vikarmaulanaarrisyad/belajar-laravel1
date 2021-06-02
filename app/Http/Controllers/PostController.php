<?php

namespace App\Http\Controllers;


//menggunakan model Post untuk menampilkan data, input dan lainya
use App\Models\Post;

//ita manfaatkan untuk mendapatkan data request dari sisi client untuk di masukkan di dalam database saat proses input data.
use Illuminate\Http\Request;

//manfaatkan untuk melakukan store atau upload data gambar ke dalam server
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //membuat method index
    public function index()
    {
        $posts = Post::latest()->when(request()->search, function ($posts) {
            $posts = $posts->where('title', 'like', '%' . request()->search . '%');
        })->paginate(5);

        return view('post.index', compact('posts'));
    }


    public function create()
    {
        return view('post.create');
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg',
            'title'     => 'required',
            'content'   => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        if ($post) {
            //redirect dengan pesan sukses
            return redirect()->route('post.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('post.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }



    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title'     => 'required',
            'content'   => 'required'
        ]);

        //get data post by ID
        $post = Post::findOrFail($post->id);

        if ($request->file('image') == "") {

            $post->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        } else {

            //hapus old image
            Storage::disk('local')->delete('public/posts/' . $post->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        }

        if ($post) {
            //redirect dengan pesan sukses
            return redirect()->route('post.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('post.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
