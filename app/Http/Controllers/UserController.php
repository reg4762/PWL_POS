<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level,'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');
        
        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }
        
        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
}

// namespace App\Http\Controllers;

// use App\Models\UserModel;
// use App\DataTables\UserDataTable;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;

// class UserController extends Controller
// {
//     public function index(UserDataTable $dataTable)
//     {
//         return $dataTable->render('user.index');
//     }

//     public function create()
//     {
//         return view('user.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'username' => 'bail|required|string|max:255',
//             'nama' => 'bail|required|string|max:255',
//             'password' => 'bail|required|string|max:255',
//             'level_id' => 'bail|required|string|max:255',
//         ]);

//         UserModel::create([
//             'username' => $request->username,
//             'nama' => $request->nama,
//             'level_id' => $request->level_id,
//             'password' => $request->password,
//         ]);
//         return redirect('/user');
//     }

//     public function edit($id)
//     {
//         $user = UserModel::find($id);
//         return view('user.edit', ['data' => $user]);
//     }

//     public function edit_simpan($id, Request $request)
//     {
//         $user = UserModel::find($id);
//         $user->username = $request->username;
//         $user->nama = $request->nama;
//         $user->password = Hash::make($request->password);
//         $user->level_id = $request->level_id;
//         $user->save();
//         return redirect('/user');
//     }

//     public function delete($id)
//     {
//         $user = UserModel::find($id);
//         $user->delete();
//         return redirect('/user');
//     }
// }