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
            $posts = $posts->where('nim', 'like', '%' . request()->search . '%');
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
            'nim'   => 'required',
            'nama_mhs'     => 'required',
            'nhp'   => 'required',
            'alamat'   => 'required',
            'image'     => 'required|image|mimes:png,jpg,jpeg'

        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $post = Post::create([
            'image'     => $image->hashName(),
            'nim'   => $request->nim,
            'nama_mhs'     => $request->nama_mhs,
            'nhp'   => $request->nhp,
            'alamat'   => $request->alamat,
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
            'nim'   => 'required',
            'nama_mhs'     => 'required',
            'nhp'   => 'required',
            'alamat'   => 'required',
            'image'     => 'required|image|mimes:png,jpg,jpeg'

        ]);

        //get data post by ID
        $post = Post::findOrFail($post->id);

        if ($request->file('image') == "") {

            $post->update([
                'nim'   => $request->nim,
                'nama_mhs'     => $request->nama_mhs,
                'nhp'   => $request->nhp,
                'alamat'   => $request->alamat

            ]);
        } else {

            //hapus old image
            Storage::disk('local')->delete('public/posts/' . $post->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            $post->update([
                'nim'   => $request->nim,
                'nama_mhs'     => $request->nama_mhs,
                'nhp'   => $request->nhp,
                'alamat'   => $request->alamat,
                'image'     => $image->hashName()
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

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::disk('local')->delete('public/posts/' . $post->image);
        $post->delete();

        if ($post) {
            //redirect dengan pesan sukses
            return redirect()->route('post.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('post.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
