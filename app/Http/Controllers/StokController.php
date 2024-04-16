<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif
        $stok = StokModel::all(); //UNTUK FILTERING
        return view('stok.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'stok' => $stok,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['user', 'barang'])->select('*');

        //Filter data stok berdasarkan stok_id
        if ($request->stok_id) {
            $stok->where('stok_id', $request->stok_id);
        }
        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $stok->stok_id) . '">' . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'stok', 'tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Stok Baru'
        ];

        $stok = StokModel::all();      //ambil data stok untuk ditampilkan di form
        $activeMenu = 'stok';//set menu yang sedang aktif
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }


    public function store(Request $request)
    {

        $request->validate([

            'barang_id' => 'bail|required|max:255',
            'user_id' => 'bail|required|max:255',
            'stok_tanggal' => 'bail|required|max:255',
            'stok_jumlah' => 'bail|required|max:255',

        ]);

        // Membuat data stok baru
        StokModel::create([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        // Redirect ke halaman stok setelah berhasil menyimpan
        return redirect('/stok');
    }

    public function edit(string $id)
    {
        $stok = StokModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit stok',
            'list' => ['Home', 'stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit stok'

        ];

        $activeMenu = 'stok'; ///set menu yang aktif
        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit user


    //Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            //kategori kode harus didisi, berupa string, minimal 3 karakter,
            //dan bernilai unik ditabel m_kategoris kolom kategori kecuali untuk katgeori dengan id yang sedang diedit
            'barang_id' => 'bail|required|max:255',
            'user_id' => 'bail|required|max:255',
            'stok_tanggal' => 'bail|required|max:255',
            'stok_jumlah' => 'bail|required|max:255',
        ]);

        StokModel::find($id)->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success', 'Data berhasil diubah');
    }


    public function show(string $id)
    {
        $stok = StokModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail stok',
            'list' => ['Home', 'stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok'; //set menu yangs edang aktif

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }
    public function destroy(string $id)
    {
        $check = StokModel::find($id);
        if (!$check) {      //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/stok')->with('error', 'Data tidak ditemukan');
        }

        try {
            StokModel::destroy($id);    //Hapus data level

            return redirect('/stok')->with('seccess', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            //Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkai dengan data ini');
        }
    }

}