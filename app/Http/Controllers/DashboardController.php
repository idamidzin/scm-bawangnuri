<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bahan;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PenguranganStok;

class DashboardController extends Controller
{
	public function index()
	{
		$supplier = User::where('role_id', 2)->where('is_valid', 1)->get();
		$distributor = User::where('role_id', 3)->where('is_valid', 1)->get();

		$supplier_item = [];
		foreach ($supplier as $row) {
			foreach ($row->Bahan as $bahan) {
				$supplier_item[] = $bahan->jumlah; 
			}
		}

		$bahan_count = array_sum($supplier_item);
		$supplier_count = count($supplier);
		$distributor_count = count($distributor);
    	$bahan = Bahan::join('users', 'users.id', '=', 'bahan.supplier_id')
                        ->where('users.is_valid', 1)
                        ->select('bahan.*')
                        ->get();

    	$bahan_supplier_bawang = Bahan::where('supplier_id', auth()->user()->id)->where('nama', 'Bawang Merah Mentah')->get();
        $bahan_supplier_tepung = Bahan::where('supplier_id', auth()->user()->id)->where('nama', 'Tepung')->get();

    	$bahan_sup_bawang = [];
    	if (count($bahan_supplier_bawang) > 0) {
    		foreach ($bahan_supplier_bawang as $row) {
    			$bahan_sup_bawang [] = $row->jumlah;
    		}
    	}

    	$bahan_supplier_bawang_count = array_sum($bahan_sup_bawang);

        $bahan_sup_tepung = [];
        if (count($bahan_supplier_tepung) > 0) {
            foreach ($bahan_supplier_tepung as $row) {
                $bahan_sup_tepung [] = $row->jumlah;
            }
        }

        $bahan_supplier_tepung_count = array_sum($bahan_sup_tepung);

    	$transaksi_supplier = Pesanan::join('bahan', 'bahan.id','=','pesanan.bahan_id')
    									->where('bahan.supplier_id', auth()->user()->id)
    									->where('pesanan.status', 2)
    									->select('pesanan.*')
    									->get();

    	$transaksi_sup = [];
    	$terjual_sup = [];
    	if (count($transaksi_supplier) > 0) {
    		foreach ($transaksi_supplier as $row) {
    			$transaksi_sup[] = $row->harga*$row->jumlah;
    			$terjual_sup[] = $row->jumlah;
    		}
    	}

    	$transaksi_sup_count = array_sum($transaksi_sup);
    	$terjual_sup_count = array_sum($terjual_sup);

        $produk = Produk::get();
        $produk_count = count($produk);

        $transaksi_produk = Pesanan::join('produk', 'produk.id','=','pesanan.produk_id')
                                        ->where('pesanan.status', 2)
                                        ->select('pesanan.*')
                                        ->get();


        $transaksi_prod = [];
        $terjual_produk = [];
        if (count($transaksi_produk) > 0) {
            foreach ($transaksi_produk as $row) {
                $transaksi_prod[] = $row->harga*$row->jumlah;
                $terjual_produk[] = $row->stok;
            }
        }

        $transaksi_produk_count = array_sum($transaksi_prod);
        $terjual_produk_count = array_sum($terjual_produk);

        $transaksi_produk_distributor = Pesanan::where('status', 2)
                                                ->where('user_id', auth()->user()->id)
                                                ->whereNotNull('produk_id')
                                                ->get();

        $transaksi_prod_distributor = [];
        if (count($transaksi_produk_distributor) > 0) {
            foreach ($transaksi_produk_distributor as $row) {
                $transaksi_prod_distributor[] = $row->harga*$row->jumlah;
            }
        }

        $transaksi_produk_distributor_count = array_sum($transaksi_prod_distributor);

        $bawang = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
                            ->where('bahan.nama', 'Bawang Merah Mentah')
                            ->where('pesanan.status', 2)
                            ->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
                            ->get();

        $stok_bawang = PenguranganStok::where('nama_bahan', 'Bawang Merah Mentah')
                                ->where('user_id', 1) //Admin
                                ->selectRaw('SUM(jumlah) as jumlah')
                                ->get();

        $tepung = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
                            ->where('bahan.nama', 'Tepung')
                            ->where('pesanan.status', 2)
                            ->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
                            ->get();

        $stok_tepung = PenguranganStok::where('nama_bahan', 'Tepung')
                                ->where('user_id', 1) //Admin
                                ->selectRaw('SUM(jumlah) as jumlah')
                                ->get();

        $stok_bawang = (string) ($bawang[0]->jumlah_stok - $stok_bawang[0]->jumlah);
        $stok_tepung = (string) ($tepung[0]->jumlah_stok - $stok_tepung[0]->jumlah);

    	return view('dashboard', compact('bahan', 'bahan_count', 'supplier_count','distributor_count', 'bahan_supplier_bawang_count','bahan_supplier_tepung_count', 'transaksi_sup_count','terjual_sup_count','produk_count','transaksi_produk_count','terjual_produk_count','produk','bahan_supplier_tepung','transaksi_produk_distributor_count', 'stok_bawang', 'stok_tepung'));	
	}
}
