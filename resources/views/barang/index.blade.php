@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success"> {{ session('success') }} </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger"> {{ session('error') }} </div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Nama Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Gambar Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataBarang = $('#table_barang').DataTable({
                serverSide: true,   //jika ingin menggunakan server side processing
                ajax: {
                    "url": "{{ url('barang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.kategori_id = $('#kategori_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",    // nomor urut dari laravel datatable addIndexColimn()
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "kategori.kategori_id",
                        className: "",
                        orderable: true,        //jika ingin kolom bisa urut
                        searchable: true        // jika kolom bisa dicari
                    }, {
                        data: "barang_kode",
                        className: "",
                        orderable: true,        //jika ingin kolom bisa diurutkan 
                        searchable: true        // jika ingin kolom bisa dicari
                    }, {
                        data: "barang_nama",
                        className: "",
                        orderable: false,       //true, jika ingin kolom diurutkan
                        searchable: false       //true, jika kolom bisa dicari
                    }, {
                        data: "harga_beli",
                        className: "",
                        orderable: false,       //true, jika ingin kolom diurutkan
                        searchable: false       //true, jika kolom bisa dicari
                    }, {
                        data: "harga_jual",
                        className: "",
                        orderable: false,       //true, jika ingin kolom diurutkan
                        searchable: false       //true, jika kolom bisa dicari
                    },
                    {
                    data: "image",
                    className: "",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<img src="' + data + '" alt="Image" class="img-thumbnail" width="100">';
                        }
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,       //true, jika ingin kolom diurutkan
                        searchable: false       //true, jika ingin kolom bisa dicari
                    }
                ]
            });
            $('#kategori_id').on('change', function() {
                dataBarang.ajax.reload();
            });
            
        });
    </script>
@endpush