@extends('layouts.app', [
    'title' => '403 | Bento Group Indonesia',
    'pageTitle' => '403 | Bento Group Indonesia',
])
@section('content')
    <div class="flex items-center justify-center w-screen h-screen  bg-gradient-to-r from-indigo-600 to-blue-400">
        <div class="px-40 py-20 bg-white rounded-md shadow-xl">
            <div class="flex flex-col items-center">
                <h1 class="font-bold text-blue-600 text-9xl">403 </h1>
                <h6 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">
                    <span class="text-red-500">Forbidden!</span> Anda Tidak Memiliki Akses Ke Halaman Ini
                </h6>
                <p class="mb-8 text-center text-gray-500 md:text-lg">
                    Forbidden.
                </p>
                <a href="{{ url()->previous() }}"
                    class="px-6 py-2 text-sm font-semibold text-blue-800 bg-blue-100">Kembali</a>
            </div>
        </div>
    </div>
@endsection
