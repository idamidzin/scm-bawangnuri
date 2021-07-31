<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Bahan;
use App\Models\Persediaan;
use App\Models\PenguranganStok;
use App\Models\User;
use App\Events\Chat;

class OrderController extends Controller
{
	public function index(Request $request)
	{
		$status = $request->get('status') ? $request->get('status') : 'baru';

		$baru = Pesanan::where('status', 0);
		$diterima = Pesanan::whereIn('status', [1,2]);
		$retur = Pesanan::where('status', 3);

		$baru_count = $baru->whereNotNull('bahan_id')->count();
		$diterima_count = $diterima->whereNotNull('bahan_id')->count();
		$retur_count = $retur->whereNotNull('bahan_id')->count();
		$trashes = Pesanan::whereNotNull('bahan_id')->onlyTrashed()->orderBy('pesanan.deleted_at','desc');

		$trash_count = $trashes->count();

		if ($status == 'baru') {
			$records = $baru->orderBy('pesanan.id', 'DESC')->whereNotNull('bahan_id')->get();
		}else if ($status == 'diterima') {
			$records = $diterima->orderBy('pesanan.id', 'DESC')->whereNotNull('bahan_id')->get();
		}else if ($status == 'retur') {
			$records = $retur->orderBy('pesanan.id', 'DESC')->whereNotNull('bahan_id')->get();
		}else{
			$records = $trashes->whereNotNull('bahan_id')->get();
		}

		$bawang = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
							->where('bahan.nama', 'Bawang Merah Mentah')
							->where('pesanan.status', 2)
							->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
							->get();

		$stok_bawang = PenguranganStok::where('nama_bahan', 'Bawang Merah Mentah')
								->where('user_id', auth()->user()->id)
								->selectRaw('SUM(jumlah) as jumlah')
								->get();

		$tepung = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
							->where('bahan.nama', 'Tepung')
							->where('pesanan.status', 2)
							->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
							->get();

		$stok_tepung = PenguranganStok::where('nama_bahan', 'Tepung')
								->where('user_id', auth()->user()->id)
								->selectRaw('SUM(jumlah) as jumlah')
								->get();

		$stok_bawang = (string) ($bawang[0]->jumlah_stok - $stok_bawang[0]->jumlah);
		$stok_tepung = (string) ($tepung[0]->jumlah_stok - $stok_tepung[0]->jumlah);

		return view('pages.admin.order.index', compact('records','status','trash_count','baru_count','diterima_count','retur_count','stok_bawang','stok_tepung'));
	}


	public function updateStok(Request $request)
	{
		if ($request->bahan == "Bawang Merah Mentah")
		{
			$bawang = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
							->where('bahan.nama', 'Bawang Merah Mentah')
							->where('pesanan.status', 2)
							->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
							->get();

			$stok_bawang = PenguranganStok::where('nama_bahan', 'Bawang Merah Mentah')
								->where('user_id', auth()->user()->id)
								->selectRaw('SUM(jumlah) as jumlah')
								->get();

			$stok_bawang = (string) ($bawang[0]->jumlah_stok - $stok_bawang[0]->jumlah);

			if ($stok_bawang <= 0) {
				return redirect()->back()->with('msg-stok', ['type' => 'danger', 'text' => 'Stok Bawang Saat ini kosong, anda tidak bisa mengurangi stok bahan bawang !']);
			}

			if ($request->jumlah > $stok_bawang) {
				return redirect()->back()->with('msg-stok', ['type' => 'danger', 'text' => 'Pengurangan Stok Bawang tidak boleh melebihi stok saat ini']);
			}
		}
		else
		{
			$tepung = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
							->where('bahan.nama', 'Tepung')
							->where('pesanan.status', 2)
							->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
							->get();

			$stok_tepung = PenguranganStok::where('nama_bahan', 'Tepung')
								->where('user_id', auth()->user()->id)
								->selectRaw('SUM(jumlah) as jumlah')
								->get();

			$stok_tepung = (string) ($tepung[0]->jumlah_stok - $stok_tepung[0]->jumlah);

			if ($stok_tepung <= 0) {
				return redirect()->back()->with('msg-stok', ['type' => 'danger', 'text' => 'Stok Tepung Saat ini kosong, anda tidak bisa mengurangi stok bahan bawang !']);
			}

			if ($request->jumlah > $stok_tepung) {
				return redirect()->back()->with('msg-stok', ['type' => 'danger', 'text' => 'Pengurangan Stok Tepung tidak boleh melebihi stok saat ini']);
			}
		}

		if ($request->target == "bahan") {
			$pengurangan = PenguranganStok::create([
				'nama_bahan' => $request->bahan,
				'user_id' => auth()->user()->id,
				'jumlah' => $request->jumlah,
				'tanggal' => date('Y-m-d H:i:s')
			]);
		}

		$bawang = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
							->where('bahan.nama', 'Bawang Merah Mentah')
							->where('pesanan.status', 2)
							->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
							->get();

		$stok_bawang = PenguranganStok::where('nama_bahan', 'Bawang Merah Mentah')
								->where('user_id', auth()->user()->id)
								->selectRaw('SUM(jumlah) as jumlah')
								->get();

		$tepung = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
							->where('bahan.nama', 'Tepung')
							->where('pesanan.status', 2)
							->selectRaw('SUM(pesanan.jumlah) as jumlah_stok')
							->get();

		$stok_tepung = PenguranganStok::where('nama_bahan', 'Tepung')
								->where('user_id', auth()->user()->id)
								->selectRaw('SUM(jumlah) as jumlah')
								->get();

		$stok_bawang = (string) ($bawang[0]->jumlah_stok - $stok_bawang[0]->jumlah);
		$stok_tepung = (string) ($tepung[0]->jumlah_stok - $stok_tepung[0]->jumlah);

		$user = User::where('role_id', 2)->get();

		if ($stok_bawang <= 100 && $stok_bawang > 0) {
			foreach ($user as $row) {
				event(new Chat($row->id,'Stok Bahan Bawang Merah Mentah di pabrik saat ini sangat minim !'));
			}
		}

		if ($stok_bawang <= 0) {
			foreach ($user as $row) {
				event(new Chat($row->id,'Stok Bahan Bawang Merah Mentah di pabrik saat ini kosong !'));
			}
		}

		if ($stok_tepung <= 100 && $stok_tepung > 0) {
			foreach ($user as $row) {
				event(new Chat($row->id,'Stok Bahan Tepung di pabrik saat ini sangat minim'));
			}
		}

		if ($stok_tepung <= 0) {
			foreach ($user as $row) {
				event(new Chat($row->id,'Stok Bahan Tepung di pabrik saat ini kosong !'));
			}
		}
		
		return redirect()->back()->with('msg-stok', ['type' => 'success', 'text' => 'Pengurangan Stok Berhasil']);
	}

	public function create()
	{
		$bahan = Bahan::where('jumlah','!=', 0)->get();
		$persediaan = Persediaan::where('status', 1)->first();
		return view('pages.admin.order.create', compact('bahan','persediaan'));
	}

	public function store(Request $request)
	{
		$order = [];
		$kebutuhan_stok = [];
		$kebutuhan_order = [];

		if ($request->bahan_id == NULL) {
			return back()->with('msg',['type'=>'danger','text'=>'Silahkan minimal memilih satu supplier!']);
		}

		$cekjumlah = [];
		foreach ($request->jumlah as $jumlah) {
			if ($jumlah != 0) {
				$cekjumlah[] = $jumlah;
			}
		}

		$cekbahan = [];
		foreach ($request->bahan_id as $bahan) {
			$cekbahan[] = $bahan ? $bahan : 0;
		}

		if (count($cekjumlah) != count($request->bahan_id)) {
			return back()->with('msg',['type'=>'danger','text'=>'Terjadi kesalahan, silahkan pilih supplier dan isi kebutuhan order dengan benar!']);
		}

		if (array_sum($cekjumlah) <= 0) {
			return back()->with('msg',['type'=>'danger','text'=>'Silahkan masukan jumlah kebutuhan order yang diinginkan !']);
		}


		$jumlah_order = [];
		for ($i=0; $i < count($request->jumlah); $i++) { 
			if ($request->jumlah[$i]) {
				$jumlah_order[] = $request->jumlah[$i];
			}
		}

		$cek_harga = [];

		foreach ($request->bahan_id as $key => $id) {
			$bahan = Bahan::where('id', $id)->orderBy('harga', 'ASC')->orderBy('jumlah', 'DESC')->first();
			$kebutuhan_stok[] = $bahan->jumlah;
			$kebutuhan_order[] = $jumlah_order[$key];
			$order[] = [
				'user_id' => auth()->user()->id,
				'bahan_id' => $bahan->id,
				'tanggal' => date('Y-m-d'),
				'keterangan' => NULL,
				'jumlah' => $jumlah_order[$key] ? $jumlah_order[$key] : 0,
				'harga' => $bahan->harga,
				'status' => 0
			];

			$cek_harga[] = $bahan->harga*($jumlah_order[$key] ? $jumlah_order[$key] : 0);
		}

		// if (array_sum($kebutuhan_order) > $request->kebutuhan) {
		// 	return back()->with('msg',['type'=>'danger','text'=>'Kebutuahn Order tidak boleh melebihi kebutuhan bahan yang sudah ditentukan!']);
		// }

		if (array_sum($kebutuhan_stok)-$request->kebutuhan < 0)
		{
			return back()->with('msg',['type'=>'danger','text'=>'Stok persediaan bahan dari supplier tidak mencukupi!']);
		}

		Pesanan::insert($order);

		foreach ($request->bahan_id as $key => $id) 
		{
			$bahan = Bahan::where('id', $id)->orderBy('harga', 'ASC')->orderBy('jumlah', 'DESC')->first();
			event(new Chat($bahan->Supplier->id,' Ada Permintaan Order'));
		}
		
		return redirect()->route('order.index')->with('msg',['type'=>'success','text'=>'Permintaan Order Berhasil ditambahkan!']);
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

		event(new Chat($pesanan->Bahan->Supplier->id,$pesan));

		return redirect()->route('order.index')->with('msg', ['type' => 'success', 'text' => $pesan]);
	}

	public function formUpload($id)
	{
		$order = Pesanan::where('id', $id)->first();
		return view('pages.admin.order.form_upload', compact('order'));
	}

	public function upload(Request $request, $id)
	{
		$order = Pesanan::where('id', $id)->first();

		$path_bukti = $order->bukti_pembayaran;

		if ($request->hasFile('bukti_pembayaran')) {
			$image      = $request->file('bukti_pembayaran');
			$fileName   = 'bukti_'.auth()->user()->hashid.'-'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('bukti_pembayaran')->storeAs('/bukti_pembayaran',$fileName,'public');
			$path_bukti = $fileName;
		}

		$order->bukti_pembayaran = $path_bukti;
		$order->update();
		
		return redirect()->route('order.index')->with('msg',['type'=>'success','text'=>'Bukti Pembayaran Berhasil dikirim!']);
	}

	public function retur(Request $request)
	{
		$pesanan = Pesanan::where('id', $request->id)->first();

		$pesanan->alasan_retur = $request->alasan;
		$pesanan->status = 3;
		$pesanan->update();

		event(new Chat($pesanan->Bahan->Supplier->id,'Pesanan diretur'));

		return redirect()->route('order.index')->with('msg',['type'=>'success','text'=>'Order diretur!']);
	}

	public function delete(Request $request)
	{
		$pesanan = Pesanan::where('id', $request->id)->first();

		$pesanan->alasan_cancel = $request->alasan;
		$pesanan->update();
		$pesanan->delete();

		return redirect()->route('order.index')->with('msg',['type'=>'success','text'=>'Order di Cancel!']);
	}

	public function destroy($id)
	{
		Pesanan::where('id',$id)->forceDelete();
		return redirect()->route('order.index')->with('msg',['type'=>'success','text'=>'Order berhasil dihapus!']);
	}

	public function restore($id)
	{
		Pesanan::where('id',$id)->restore();
		return redirect()->route('order.index')->with('msg',['type'=>'success','text'=>'Order berhasil direstore!']);
	}
}
