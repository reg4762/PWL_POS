@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('user') }}" class="form-horizontal"> @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Level</label>
                    <div class="col-11">
                        <select class="form-control" id="level_id" name="level_id" required>
                            <option value="">- Pilih Level -</option>
                            @foreach ($level as $item)
                                <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                            @endforeach
                        </select> @error('level_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Username</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                            required>
                        @error('nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Password</label>
                    <div class="col-11">
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection @push('css')
    @endpush @push('js')
@endpush


{{-- @extends('layout.app') --}}

{{-- Customize layout sections --}}
{{-- @section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Create') --}}

{{-- Content body: main page content
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah user baru</h3>
            </div>
            <form method="post" action="../user">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username">
                    @error('username')
                        <div class="alert  alert-danger">{{ $message }}</div>  
                    @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama">
                    @error('nama')
                        <div class="alert  alert-danger">{{ $message }}</div>  
                    @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                    @error('password')
                        <div class="alert  alert-danger">{{ $message }}</div>  
                    @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="level_id">ID Level</label>
                        <input type="number" class="form-control @error('level_id') is-invalid @enderror" id="level_id" name="level_id" placeholder="Id Level">
                    @error('level_id')
                        <div class="alert  alert-danger">{{ $message }}</div>  
                    @enderror
                    </div>
                </div>
               
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary fileinput-button">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection --}}
