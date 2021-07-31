<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Bahan;
use App\Events\Chat;

class PesananController extends Controller
{
	public function index(Request $request)
	{
		$status = $request->get('status') ? $request->get('status') : 'baru';

		$baru = Pesanan::where('status', 0);
		$diterima = Pesanan::whereIn('status', [1,2]);
		$retur = Pesanan::where('status', 3);

		$baru_count = $baru->whereNotNull('produk_id')->count();
		$diterima_count = $diterima->whereNotNull('produk_id')->count();
		$retur_count = $retur->whereNotNull('produk_id')->count();
		$trashes = Pesanan::whereNotNull('produk_id')->onlyTrashed()->orderBy('deleted_at','desc');

		$trash_count = $trashes->count();

		if ($status == 'baru') {
			$records = $baru->orderBy('id', 'DESC')->whereNotNull('produk_id')->get();
		}else if ($status == 'diterima') {
			$records = $diterima->orderBy('id', 'DESC')->whereNotNull('produk_id')->get();
		}else if ($status == 'retur') {
			$records = $retur->orderBy('id', 'DESC')->whereNotNull('produk_id')->get();
		}else{
			$records = $trashes->whereNotNull('produk_id')->get();
		}

		return view('pages.admin.pesanan.index', compact('records','status','trash_count','baru_count','diterima_count','retur_count'));
	}

	public function proses(Request $request, $id)
	{
		$pesanan = Pesanan::where('id', $id)->first();
		$produk = Produk::where('id', $pesanan->produk_id)->first();

		if ($pesanan->status != 0) {
			if ($request->status == '0') {
				$produk->stok = $produk->stok+$pesanan->jumlah;
				$produk->update();
			}
		}

		$pesanan->status = $request->status;
		$pesanan->update();

		if (($produk->stok-$pesanan->jumlah) < 0) {
			return redirect()->route('pesanan_produk.index')->with('msg', ['type' => 'danger', 'text' => 'Jumlah yang di pesan melebihi stok produk !']);
		}

		$produk->stok = $produk->stok-$pesanan->jumlah;
		$produk->update();

		event(new Chat($pesanan->User->id,'Permintaan Order Produk Diterima'));

		return redirect()->route('pesanan_produk.index')->with('msg', ['type' => 'success', 'text' => 'Pesanan berhasil di proses !']);
	}


	public function prosesRetur(Request $request, $id)
	{
		$pesanan = Pesanan::where('id', $id)->first();

		$pesanan->status = $request->status;
		$pesanan->update();

		event(new Chat($pesanan->User->id,'Permintaan Order Produk Retur sedang di proses'));

		return redirect()->route('pesanan_produk.index')->with('msg', ['type' => 'success', 'text' => 'Pesanan retur berhasil di proses !']);
	}

	public function delete(Request $request)
	{
		$pesanan = Pesanan::where('id', $request->id)->first();

		// $produk = Produk::where('id', $pesanan->produk_id)->first();

		// $produk->stok = $produk->stok + $pesanan->jumlah;
		// $produk->update();
		$pesanan->delete();

		return redirect()->route('pesanan_produk.index')->with('msg',['type'=>'success','text'=>'Pesanan di Cancel!']);
	}

	public function destroy($id)
	{
		Pesanan::where('id',$id)->forceDelete();
		return redirect()->route('pesanan_produk.index')->with('msg',['type'=>'success','text'=>'Pesanan berhasil dihapus!']);
	}

	public function restore($id)
	{
		$pesanan = Pesanan::where('id', $id)->first();

		// $produk = Produk::where('id', $pesanan->produk_id)->first();

		// $produk->stok = $produk->stok + $pesanan->jumlah;
		// $produk->update();
		$pesanan->restore();
		return redirect()->route('pesanan_produk.index')->with('msg',['type'=>'success','text'=>'Pesanan berhasil direstore!']);
	}

	public function getPesananBaru()
	{
		$pesanan_produk = Pesanan::where('status', 0)
                                    ->whereNotNull('produk_id')
                                    ->get();

        return $this->successJSON([
        	'pesanan_produk_count' => count($pesanan_produk),
        ]);
	}
}
