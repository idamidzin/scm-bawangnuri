<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
	public function index()
	{
		$user = auth()->user();
		return view('pages.admin.profile.index', compact('user'));
	}

	public function update(Request $request, $id)
	{
		$user = User::where('id', $id)->first();

		$user->nama = $request->nama;
		$user->email = $request->email;

		if ($request->password) {
			$user->password = bcrypt($request->password);
		}

		$user->nohp = $request->nohp;
		$user->jenis_kelamin = $request->jenis_kelamin;
		$user->alamat = $request->alamat;
		$user->foto = $request->foto;
		$user->nama_rekening = $request->nama_rekening;
		$user->no_rekening = $request->no_rekening;
		$user->update();

		return redirect()->back()->with('msg', ['type' => 'success', 'text' => 'Profile Berhasil diperbarui!']);
	}
}
