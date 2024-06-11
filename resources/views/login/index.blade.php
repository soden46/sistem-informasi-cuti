@extends('layouts.main')

@section('content')
<main class="form-signin w-100 m-auto">
    @include('component.alert-dismissible')
    <form action="/authenticate" method="post">
        @csrf
        <h1 class="h3 mb-3 fw-normal">MASUK</h1>
        <div class="form-floating">
            <label for="nama_emp">Nama</label>
            <input type="nama_emp" name="nama_emp" class="form-control @error('nama_emp')is-invalid @enderror" id="nama_emp" placeholder="Nama" value="{{old('nama_emp')}}" autofocus required>
            @error('nama_emp')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-floating">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">MASUK</button>
        <p class="mt-2 mb-1 text-muted"><a href="/register">Butuh Akun?</a></p>
        <p><a href="">Lupa Password</a></p>
    </form>
</main>
@endsection