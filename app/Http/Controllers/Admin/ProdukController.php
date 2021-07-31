<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Produk::query();
		$produk_count = $records->count();

		$trashes = Produk::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();
		$records = $is_trash 
		? $trashes->get() 
		: $records->get();

		return view('pages.admin.produk.index', compact('records','is_trash','trash_count','produk_count'));
	}

	public function create()
	{
		return view('pages.admin.produk.create');
	}

	public function edit($id)
	{
		$records = Produk::where('id', $id)->first();

		return view('pages.admin.produk.edit', compact('records'));
	}

	public function update(Request $request, $id)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);
		$produk = Produk::where('id', $id)->first();

		if (!$produk) {
			return redirect()->route('produk.index')->with('msg', ['type' => 'danger', 'text' => 'Produk tidak ditemukan !']);
		}

		$path_foto = $produk->foto;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'produk_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/produk',$fileName,'public');
			$path_foto = $fileName;
		}

		$produk->nama = $request->nama;
		$produk->stok = $request->stok;
		$produk->harga = $harga;
		$produk->satuan = $request->satuan;
		$produk->foto = $path_foto;
		$produk->keterangan = $request->keterangan;
		$produk->update();

		return redirect()->route('produk.index')->with('msg', ['type' => 'Success', 'text' => 'Produk berhasil diperbaharui !']);
	}

	public function store(Request $request)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$path_foto = null;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'produk_'.uniqid().'.' . $image->getClientOriginalExtension();
			$request->file('foto')->storeAs('/produk',$fileName,'public');
			$path_foto = $fileName;
		}

		$bahan = Produk::create([
			'nama' => $request->nama,
			'stok' => $request->stok,
			'harga' => $harga,
			'satuan' => $request->satuan,
			'foto' => $path_foto,
			'keterangan' => $request->keterangan,
		]);

		return redirect()->route('produk.index')->with('msg', ['type' => 'success', 'text' => 'Produk berhasil ditambahkan !']);
	}

	public function delete($id)
	{
		Produk::where('id',$id)->delete();
		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil dihapus!']);
	}

	public function destroy($id)
	{
		Produk::where('id',$id)->forceDelete();
		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil dihapus!']);
	}

	public function restore($id)
	{
		Produk::where('id',$id)->restore();
		return redirect()->route('produk.index')->with('msg',['type'=>'success','text'=>'Produk berhasil direstore!']);
	}
}
