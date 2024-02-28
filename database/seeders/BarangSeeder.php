<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'bar1',
                'barang_nama' => 'Radio',
                'harga_beli' => '100000',
                'harga_jual' => '150000',
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'bar2',
                'barang_nama' => 'TV',
                'harga_beli' => '300000',
                'harga_jual' => '350000',
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'bar3',
                'barang_nama' => 'Gelang',
                'harga_beli' => '50000',
                'harga_jual' => '100000',
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'bar4',
                'barang_nama' => 'Cincin',
                'harga_beli' => '100000',
                'harga_jual' => '150000',
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'bar5',
                'barang_nama' => 'Celana',
                'harga_beli' => '200000',
                'harga_jual' => '250000',
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'bar6',
                'barang_nama' => 'Baju',
                'harga_beli' => '170000',
                'harga_jual' => '200000',
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'bar7',
                'barang_nama' => 'Roti',
                'harga_beli' => '10000',
                'harga_jual' => '15000',
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'bar8',
                'barang_nama' => 'Makaroni',
                'harga_beli' => '20000',
                'harga_jual' => '25000',
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'bar9',
                'barang_nama' => 'Buku',
                'harga_beli' => '30000',
                'harga_jual' => '40000',
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'bar10',
                'barang_nama' => 'Pensil',
                'harga_beli' => '5000',
                'harga_jual' => '10000',
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
