<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\Chat;

class UserController extends Controller
{
	public function index(Request $request)
	{
		$req = $request->get('req') ? $request->get('req') : 'Supplier';

		$supplier = User::join('role', 'role.id','=','users.role_id')
							->select('users.*')
							->where('role.nama', 'Supplier');
		$distributor = User::join('role', 'role.id','=','users.role_id')
							->select('users.*')
							->where('role.nama', 'Distributor');

		$trasher = User::onlyTrashed()->orderBy('deleted_at','desc');

		$supplier_count = $supplier->count();
		$distributor_count = $distributor->count();
		$trash_count = $trasher->count();

		if ($req == 'Supplier') {
			$records = $supplier->orderBy('id', 'DESC')->get();
		}else if ($req == 'Distributor') {
			$records = $distributor->orderBy('id', 'DESC')->get();
		}else{
			$records = $trasher->get();
		}

		return view('pages.admin.pengguna.index',compact('records','req','supplier_count','distributor_count','trash_count'));
	}

	public function create(){
		return view('pages.admin.pengguna.create');
	}

	public function store(Request $request)
	{
		$cek_hak = User::where('role', $request->role)->first();

		$hak = null;
		if ($request->role == 2) {
			$hak = "Kepala Desa";
		}
		else if ($request->role == 3) {
			$hak = "Sekretaris Desa";
		}
		else if ($request->role == 4) {
			$hak = "Badan Permusyaratan Desa";
		}

		if ($cek_hak != null) {
			return back()->with('msg',['type'=>'danger','text'=>'Hak Akses untuk '.$hak.' Sudah digunakan !'])->withInput();
		}

		User::create([
			'nama'=>$request->nama,
			'username'=>$request->username,
			'password'=>bcrypt($request->password),
			'email'=>$request->email,
			'role'=> $request->role,
		]);
		return redirect()->route('user.index')->with('msg',['type'=>'success','text'=>'User berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$user = User::where('id', $id)->first();
		return view('pages.pengguna.edit', compact('user'));
	}

	public function update(Request $request, $id)
	{
		$user = User::where('id',$id)->first();
		if(!$user)
		{
			return redirect()->route('user.index')->with('msg',[
				'type'=>'warning','text'=>'user tidak ditemukan!'
			]);
		}

		if(is_null($request->password)){
			$user->nama = $request->nama;
			$user->username = $request->username;
			$user->email = $request->email;
		}else{
			$user->nama = $request->nama;
			$user->username = $request->username;
			$user->password = bcrypt($request->password);
			$user->email = $request->email;
		}

		$user->save();

		return redirect()->route('user.index')->with('msg',['type'=>'success','text'=>'User berhasil diperbaharui!']);
	}

	public function delete($id)
	{
		User::where('id',$id)->delete();
		return redirect()->route('user.index')->with('msg',['type'=>'success','text'=>'User berhasil dihapus!']);
	}

	public function destroy($id)
	{
		User::where('id',$id)->forceDelete();
		return redirect()->route('user.index')->with('msg',['type'=>'success','text'=>'User berhasil dihapus!']);
	}

	public function restore($id)
	{
		User::where('id',$id)->restore();
		return redirect()->route('user.index')->with('msg',['type'=>'success','text'=>'User berhasil direstore!']);
	}

	public function validasi($id)
	{
		$user = User::where('id',$id)->first();
		$user->is_valid = 1;
		$user->update();

		return redirect()->route('user.index')->with('msg',['type'=>'success','text'=>'User berhasil divalidasi!']);
	}

	public function Call(Request $request)
	{
		$user = User::where('id', $request->call_id)->first();

		event(new Chat($request->call_id,'Ada Penawaran dari '.$user->nama));

		echo 'ok';
	}
}
