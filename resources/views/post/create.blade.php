@extends('layouts.app', ['title' => 'Tambah Data Mahasiswa'])

@section('content')

    <div class="container mx-auto mt-10 mb-10">
        <div class="bg-white p-5 rounded shadow-sm">
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div>
                    <label>GAMBAR POST</label>
                    <input type="file" name="image"
                        class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2">
                    @error('image')
                        <div class="bg-red-400 p-2 shadow-sm rounded mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-5">
                    <label>NIM Mahasiswa</label>
                    <input type="text" name="nim" value="{{ old('title') }}"
                        class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2"
                        placeholder="NIM Mahasiswa">
                    @error('title')
                        <div class="bg-red-400 p-2 shadow-sm rounded mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-5">
                    <label>Nama Mahasiswa</label>
                    <input type="text" name="nama_mhs" value="{{ old('title') }}"
                        class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2"
                        placeholder="Nama Mahasiswa">
                    @error('title')
                        <div class="bg-red-400 p-2 shadow-sm rounded mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-5">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="{{ old('title') }}"
                        class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2"
                        placeholder="Alamat">
                    @error('title')
                        <div class="bg-red-400 p-2 shadow-sm rounded mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-5">
                    <label>No HP</label>
                    <input type="text" name="nhp" value="{{ old('title') }}"
                        class="w-full bg-gray-200 p-2 rounded shadow-sm border border-gray-200 focus:outline-none focus:bg-white mt-2"
                        placeholder="No HP">
                    @error('title')
                        <div class="bg-red-400 p-2 shadow-sm rounded mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mt-5">
                    <button type="submit"
                        class="bg-indigo-500 text-white p-2 rounded shadow-sm focus:outline-none hover:bg-indigo-700">SIMPAN
                        POST</button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');

    </script>

@endsection
