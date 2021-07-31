<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Persediaan;
use App\Events\Chat;

class OrderController extends Controller
{
	public function index(Request $request)
	{
		$status = $request->get('status') ? $request->get('status') : 'baru';

		$baru = Pesanan::where('status', 0)->where('user_id', auth()->user()->id)->whereNotNull('produk_id');
		$diterima = Pesanan::whereIn('status', [1,2])->where('user_id', auth()->user()->id)->whereNotNull('produk_id');
		$retur = Pesanan::where('status', 3)->where('user_id', auth()->user()->id)->whereNotNull('produk_id');

		$baru_count = $baru->count();
		$diterima_count = $diterima->count();
		$retur_count = $retur->count();
		$trashes = Pesanan::onlyTrashed()->whereNotNull('produk_id')->where('user_id', auth()->user()->id)->orderBy('deleted_at','desc');

		$trash_count = $trashes->count();

		if ($status == 'baru') {
			$records = $baru->orderBy('id', 'DESC')->get();
		}else if ($status == 'diterima') {
			$records = $diterima->orderBy('id', 'DESC')->get();
		}else if ($status == 'retur') {
			$records = $retur->orderBy('id', 'DESC')->get();
		}else{
			$records = $trashes->get();
		}

		return view('pages.distributor.order.index', compact('records','status','trash_count','baru_count','diterima_count','retur_count'));
	}

	public function create()
	{
		$produk = Produk::where('stok','!=', 0)->get();
		return view('pages.distributor.order.create', compact('produk'));
	}

	public function store(Request $request)
	{
		$order = [];
		$kebutuhan_stok = [];
		$kebutuhan_order = [];

		if ($request->produk_id == NULL) {
			return back()->with('msg',['type'=>'danger','text'=>'Silahkan minimal memilih satu produk!']);
		}

		$cekjumlah = [];
		foreach ($request->jumlah as $jumlah) {
			if ($jumlah != 0) {
				$cekjumlah[] = $jumlah;
			}
		}

		$cekbahan = [];
		foreach ($request->produk_id as $bahan) {
			$cekbahan[] = $bahan ? $bahan : 0;
		}

		if (count($cekjumlah) != count($request->produk_id)) {
			return back()->with('msg',['type'=>'danger','text'=>'Terjadi kesalahan, silahkan pilih produk dan isi kebutuhan order dengan benar!']);
		}

		if (array_sum($cekjumlah) <= 0) {
			return back()->with('msg',['type'=>'danger','text'=>'Silahkan masukan jumlah kebutuhan order yang diinginkan !']);
		}

		$error = [];
		$inserted = 0;
		foreach ($request->produk_id as $key => $id) 
		{
			$produk = Produk::where('id', $id)->orderBy('harga', 'ASC')->orderBy('stok', 'DESC')->first();
			$kebutuhan_stok[] = $produk->stok;
			$kebutuhan_order[] = $request->jumlah[$key];

			if ($request->jumlah[$key] > $produk->stok) {
				$error[] = 'Order digagalkan, Jumlah Produk '.$produk->nama.' tidak mencukupi permintaan order anda!';
			}else{
				$inserted++;
				$order[] = [
					'user_id' => auth()->user()->id,
					'produk_id' => $produk->id,
					'tanggal' => date('Y-m-d'),
					'keterangan' => NULL,
					'jumlah' => $request->jumlah[$key],
					'harga' => $produk->harga,
					'status' => 0
				];
			}
		}

		if ($inserted == 0) 
		{
			return redirect()->back()
					->with('msg',['type'=>'danger','text'=>'Order Digagalkan, Tidak ada permintaan order yang valid!'])
					->with('errorOrder',$error);
		}else{
			Pesanan::insert($order);
			foreach ($request->produk_id as $key => $id) 
			{
				$produk = Produk::where('id', $id)->orderBy('harga', 'ASC')->orderBy('stok', 'DESC')->first();
				event(new Chat(1,' Ada Permintaan Order Produk'));
			}
		}
		
		return redirect()->route('distributor.order.index')
						->with('msg',['type'=>'success','text'=>'Permintaan Order Berhasil ditambahkan!'])
						->with('errorOrder',$error);

	}

	public function proses(Request $request, $id)
	{
		$pesanan = Pesanan::where('id', $id)->first();

		$pesanan->status = $request->status;
		$pesanan->update();

		if ($request->status == 2) {
			$pesan = 'Pesanan berhasil di terima';
		}
		else if ($request->status == 3) {
			$pesan = 'Pesanan telah di Retur';
		}

		event(new Chat(1,$pesan));

		return redirect()->route('distributor.order.index')->with('msg', ['type' => 'success', 'text' => $pesan]);
	}

	public function formUpload($id)
	{
		$order = Pesanan::where('id', $id)->first();
		return view('pages.distributor.order.form_upload', compact('order'));
	}

	public function upload(Request $request, $id)
	{
		$order = Pesanan::where('id', $id)->first();

		$path_bukti = $order->bukti_pembayaran;

		if ($request->hasFile('bukti_pembayaran')) {
			$image      = $request->file('bukti_pembayaran');
			$fileName   = 'bukti_'.auth()->user()->hashid.'-'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('bukti_pembayaran')->storeAs('/bukti_pembayaran_order_produk',$fileName,'public');
			$path_bukti = $fileName;
		}

		$order->bukti_pembayaran = $path_bukti;
		$order->update();
		
		return redirect()->route('distributor.order.index')->with('msg',['type'=>'success','text'=>'Butki Pembayaran Berhasil dikirim!']);
	}

	public function retur(Request $request)
	{
		$pesanan = Pesanan::where('id', $request->id)->first();

		$pesanan->alasan_retur = $request->alasan;
		$pesanan->status = 3;
		$pesanan->update();

		event(new Chat(1,'Pesanan diretur'));

		return redirect()->route('distributor.order.index')->with('msg',['type'=>'success','text'=>'Order diretur!']);
	}


	public function delete(Request $request)
	{
		$pesanan = Pesanan::where('id', $request->id)->first();

		// $produk = Produk::where('id', $pesanan->produk_id)->first();

		// $produk->stok = $produk->stok + $pesanan->jumlah;
		// $produk->update();

		$pesanan->alasan_cancel = $request->alasan;
		$pesanan->update();
		$pesanan->delete();

		return redirect()->route('distributor.order.index')->with('msg',['type'=>'success','text'=>'Order di Cancel!']);
	}

	public function destroy($id)
	{
		Pesanan::where('id',$id)->forceDelete();
		return redirect()->route('distributor.order.index')->with('msg',['type'=>'success','text'=>'Order berhasil dihapus!']);
	}

	public function restore($id)
	{
		$pesanan = Pesanan::where('id', $id)->first();

		// $produk = Produk::where('id', $pesanan->produk_id)->first();

		// $produk->stok = $produk->stok - $pesanan->jumlah;
		// $produk->update();

		$pesanan->restore();
		return redirect()->route('distributor.order.index')->with('msg',['type'=>'success','text'=>'Order berhasil direstore!']);
	}
}