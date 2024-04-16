<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\View\View;

// use function PHPUnit\Framework\returnSelf;

class KategoriController extends Controller
{
    // public function index()
    // {
    //     // $data = [
    //     // 'kategori_kode' => 'SNK',
    //     // 'kategori_nama' => 'Snack/Makanan Ringan',
    //     // 'created_at' => now()
    //     //  ];
    //     // DB::table('m_kategori') -> insert($data);
    //     // return 'insert data baru berhasil';

    //     // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
    //     // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row. ' baris';

    //     $data = DB::table('m_kategori')->get();
    //     return view('kategori', ['data' => $data]);
    // }

    // public function index(KategoriDataTable $dataTable)
    // {
    //     return $dataTable->render('kategori.index');
    // }

    // public function create() : View
    // {
    //     return view('kategori.create');
    // }

    // public function store(Request $request) : RedirectResponse
    // {
    //     $request->validate([
    //         'kodeKategori' => 'bail|required|string|max:255',
    //         'namaKategori' => 'bail|required|string|max:255',
    //     ]);
    // KategoriModel::create([
    //     'kategori_kode' => $request->kodeKategori, // Menyertakan nilai kategori_kode dari form
    //     'kategori_nama' => $request->namaKategori,
    // ]);
    // return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori.edit',['data' => $kategori]);
    // }
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';  //set menu yang sedang aktiv
        $kategori = KategoriModel::all();     //ambil data untuk filter 
        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');
        //Filter data user berdasarkan kategori_id
        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }
        return DataTables::of($kategori)
            ->addIndexColumn()  //menambahkan kolom index/ no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];
        $page = (object) [
            'title' => 'tambah kategori baru'
        ];

        $kategori = KategoriModel::all();      //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; //set menu yang sedang aktif
        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'kategori_kode' => 'bail|required|unique:m_kategori|max:255',
            'kategori_nama' => 'bail|required|max:255',

        ]);
        // Membuat data kategori baru
        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        // Redirect ke halaman kategori setelah berhasil menyimpan
        return redirect('/kategori')->with('success', 'Data Kategori berhasil disimpan');;
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail kategori',
            'list' => ['Home', 'kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori'; //set menu yangs edang aktif

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'

        ];

        $activeMenu = 'Kategori'; ///set menu yang aktif
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit user


    //Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            //kategori kode harus didisi, berupa string, minimal 3 karakter,
            //dan bernilai unik ditabel m_kategori kolom kategori kecuali untuk katgeori dengan id yang sedang diedit
            'kategori_kode' => 'bail|required|max:255',
            'kategori_nama' => 'bail|required|unique:m_kategori|max:255',
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data berhasil diubah');
    }
    public function delete($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }


    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {      //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/kategori')->with('error', 'Data tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);    //Hapus data level

            return redirect('/kategori')->with('seccess', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            //Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkai dengan data ini');
        }
    }
}



// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use App\DataTables\KategoriDataTable;
// use App\Models\KategoriModel;
// use Illuminate\Contracts\View\View;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Support\Facades\Redirect;

// class KategoriController extends Controller
// {
//     public function index(KategoriDataTable $dataTable)
//     {
//         return $dataTable->render('kategori.index');
//     }

//     public function create(): View
//     {
//         return view('kategori.create');
//     }

//     public function store(Request $request): RedirectResponse
//     {
//         $request->validate([
//             'kodeKategori' => 'bail|required|string|max:255',
//             'namaKategori' => 'bail|required|string|max:255',
//         ]);

//         KategoriModel::create([
//             'kategori_kode' => $request->kodeKategori,
//             'kategori_nama' => $request->namaKategori,
//         ]);
//         return redirect('/kategori');
//     }

//     public function edit($id)
//     {
//         $kategori = KategoriModel::find($id);
//         return view('kategori.edit',['data' => $kategori]);
//     }

//     public function edit_simpan($id, Request $request)
//     {
//         $kategori = KategoriModel::find($id);

//         $kategori->kategori_kode = $request->kodeKategori;
//         $kategori->kategori_nama = $request->namaKategori;

//         $kategori->save();

//         return redirect('/kategori');
//     }

//     public function destroy($id)
//     {
//         $kategori = KategoriModel::find($id);
//         $kategori->delete();

//         return redirect('/kategori');
//     }
// }