@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Create User</h1>
@stop

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Data User</h3>
    </div>
    <div class="card-body">
        <form method="post" action="/user/tambah_simpan">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <div class="form-group">
                <label for="level_id">Level ID</label>
                <input type="number" class="form-control" id="level_id" name="level_id">
            </div>
            <input type="submit" name="btn btn-success" value="Simpan">
        </form>
    </div>
</div>
@stop



{{-- <!DOCTYPE html>
<html>

<head>
    <title>Data User</title>
</head>

<body>
    <h1>Form Tambah Data User</h1>
    <form method="post" action="/user/tambah_simpan">

        {{ csrf_field() }}
        
        <br>
        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br>
        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>
        <input type="submit" name="btn btn-success" value="Simpan">
    </form>
</body>

</html> --}}
