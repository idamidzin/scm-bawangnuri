<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Bahan;
use App\Events\Chat;

class PesananController extends Controller
{
	public function index(Request $request)
	{
		$status = $request->get('status') ? $request->get('status') : 'baru';

		$baru = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
						->where('supplier_id', auth()->user()->id)
						->where('status', 0);
		$diterima = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
						->where('supplier_id', auth()->user()->id)
						->whereIn('status', [1,2]);
		$retur = Pesanan::join('bahan', 'bahan.id', '=', 'pesanan.bahan_id')
						->where('supplier_id', auth()->user()->id)
						->where('status', 3);

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

		return view('pages.supplier.pesanan.index', compact('records','status','trash_count','baru_count','diterima_count','retur_count'));
	}

	public function proses(Request $request, $id)
	{
		$pesanan = Pesanan::where('id', $id)->first();
		$bahan = Bahan::where('id', $pesanan->bahan_id)->first();

		if ($pesanan->status != 0) {
			if ($request->status == '0') {
				$bahan->jumlah = $bahan->jumlah+$pesanan->jumlah;
				$bahan->update();
			}
		}

		if (($bahan->jumlah-$pesanan->jumlah) < 0) {
			return redirect()->route('supplier.pesanan.index')->with('msg', ['type' => 'danger', 'text' => 'Jumlah yang di pesan melebihi stok bahan !']);
		}

		if ($pesanan->status == 0) {
			$bahan->jumlah = $bahan->jumlah-$pesanan->jumlah;
			$bahan->update();
		}

		$pesanan->status = $request->status;
		$pesanan->update();

		event(new Chat($pesanan->User->id,'Permintaan Order Diterima'));

		return redirect()->route('supplier.pesanan.index')->with('msg', ['type' => 'success', 'text' => 'Pesanan berhasil di proses !']);
	}

	public function prosesRetur(Request $request, $id)
	{
		$pesanan = Pesanan::where('id', $id)->first();

		$pesanan->status = $request->status;
		$pesanan->update();

		event(new Chat($pesanan->User->id,'Permintaan Order Bahan Baku Retur sedang di proses'));

		return redirect()->route('supplier.pesanan.index')->with('msg', ['type' => 'success', 'text' => 'Pesanan retur berhasil di proses !']);
	}

	public function formUpload($id)
	{
		$pesanan = Pesanan::where('id', $id)->first();
		return view('pages.supplier.pesanan.form_upload', compact('pesanan'));
	}

	public function upload(Request $request, $id)
	{
		$pesanan = Pesanan::where('id', $id)->first();

		$path_bukti = $pesanan->bukti_pembayaran_retur;

		if ($request->hasFile('bukti_pembayaran_retur')) {
			$image      = $request->file('bukti_pembayaran_retur');
			$fileName   = 'bukti_'.auth()->user()->hashid.'-'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('bukti_pembayaran_retur')->storeAs('/bukti_pembayaran_retur',$fileName,'public');
			$path_bukti = $fileName;
		}

		$pesanan->bukti_pembayaran_retur = $path_bukti;
		$pesanan->update();
		
		return redirect()->route('supplier.pesanan.index')->with('msg',['type'=>'success','text'=>'Bukti Pembayaran Retur Berhasil dikirim!']);
	}

	public function delete(Request $request)
	{
		$pesanan = Pesanan::where('id', $request->id)->first();

		$pesanan->alasan_cancel = $request->alasan;
		$pesanan->update();
		$pesanan->delete();

		return redirect()->route('supplier.pesanan.index')->with('msg',['type'=>'success','text'=>'Pesanan di Cancel!']);
	}

	public function destroy($id)
	{
		Pesanan::where('id',$id)->forceDelete();
		return redirect()->route('supplier.pesanan.index')->with('msg',['type'=>'success','text'=>'Pesanan berhasil dihapus!']);
	}

	public function restore($id)
	{
		Pesanan::where('id',$id)->restore();
		return redirect()->route('supplier.pesanan.index')->with('msg',['type'=>'success','text'=>'Pesanan berhasil direstore!']);
	}

	public function getPesananBaru()
	{
		$pesanan_bahan = Pesanan::join('bahan', 'bahan.id','=','pesanan.bahan_id')
                                    ->where('status', 0)
                                    ->whereNotNull('bahan_id')
                                    ->where('bahan.supplier_id', auth()->user()->id)
                                    ->get();

        return $this->successJSON([
        	'pesanan_bahan_count' => count($pesanan_bahan),
        ]);
	}
}
