<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bahan;

class BahanController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Bahan::query();
		$bahan_count = $records->where('supplier_id', auth()->user()->id)->count();

		$trashes = Bahan::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();
		$records = $is_trash 
					? $trashes->where('supplier_id', auth()->user()->id)->get() 
					: $records->where('supplier_id', auth()->user()->id)->get();

		return view('pages.supplier.bahan.index', compact('records','is_trash','trash_count','bahan_count'));
	}

	public function create()
	{
		return view('pages.supplier.bahan.create');
	}

	public function edit($id)
	{
		$records = Bahan::where('id', $id)->first();

		return view('pages.supplier.bahan.edit', compact('records'));
	}

	public function update(Request $request, $id)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);
		$bahan = Bahan::where('id', $id)->first();

		if (!$bahan) {
			return redirect()->route('supplier.bahan.index')->with('msg', ['type' => 'danger', 'text' => 'Bahan tidak ditemukan !']);
		}

		$bahan->nama = $request->nama;
		$bahan->jumlah = $request->jumlah;
		$bahan->harga = $harga;
		$bahan->satuan = 'Kg';
		$bahan->update();

		return redirect()->route('supplier.bahan.index')->with('msg', ['type' => 'Success', 'text' => 'Bahan berhasil diperbaharui !']);
	}

	public function store(Request $request)
	{
		$harga = preg_replace('/[Rp.]/','',$request->harga);

		$bahan = Bahan::where('nama', $request->nama)->first();

		if ($bahan)
		{
			$addmsg = "";
			if((int)$bahan->harga != (int)$harga){
				$addmsg = "dan harga berubah menjadi ".$request->harga;	
			}

			$bahan->jumlah = $bahan->jumlah + $request->jumlah;
			$bahan->harga = $harga;
			$bahan->update();

			$msg = "Bahan berhasil ditambahkan ".$addmsg;
		}
		else
		{
			$bahan = Bahan::create([
				'nama' => $request->nama,
				'jumlah' => $request->jumlah,
				'harga' => $harga,
				'satuan' => 'Kg',
				'supplier_id' => auth()->user()->id
			]);

			$msg = "Bahan berhasil ditambahkan";
		}

		return redirect()->route('supplier.bahan.index')->with('msg', ['type' => 'success', 'text' => $msg]);
	}

	public function delete($id)
	{
		Bahan::where('id',$id)->delete();
		return redirect()->route('supplier.bahan.index')->with('msg',['type'=>'success','text'=>'Bahan berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Bahan::where('id',$id)->forceDelete();
		return redirect()->route('supplier.bahan.index')->with('msg',['type'=>'success','text'=>'Bahan berhasil dihapus!']);
	}

	public function restore($id)
	{
		Bahan::where('id',$id)->restore();
		return redirect()->route('supplier.bahan.index')->with('msg',['type'=>'success','text'=>'Bahan berhasil direstore!']);
	}
}
